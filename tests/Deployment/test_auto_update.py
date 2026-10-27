"""Exercise deployment state transitions with real Git and stubbed services.

Run: python3 -m unittest discover -s tests/Deployment -v
"""
import os
import fcntl
from pathlib import Path
import shutil
import subprocess
import tempfile
import unittest


ROOT = Path(__file__).resolve().parents[2]


class AutoUpdateTest(unittest.TestCase):
    def setUp(self):
        self.temp = tempfile.TemporaryDirectory()
        self.addCleanup(self.temp.cleanup)
        self.root = Path(self.temp.name)
        self.remote = self.root / "origin.git"
        self.source = self.root / "source"
        self.app = self.root / "app"
        self.deploy = self.root / "deploy"
        self.public = self.root / "public_html"
        self.bin = self.root / "bin"
        for directory in (self.deploy, self.public, self.bin):
            directory.mkdir()
        self.git("init", "--bare", str(self.remote))
        self.git("clone", str(self.remote), str(self.source))
        self.git("checkout", "-b", "main", cwd=self.source)
        for name in ("composer.lock", "package-lock.json", "artisan", "public/index.php", "deploy/public-html-index.php"):
            path = self.source / name
            path.parent.mkdir(exist_ok=True)
            path.write_text("initial\n")
        (self.source / ".gitignore").write_text(".env\nvendor/\npublic/build/\nstorage/\n")
        self.commit("initial")
        self.git("clone", "-b", "main", str(self.remote), str(self.app))
        (self.app / ".env").touch()
        (self.app / "vendor").mkdir()
        (self.app / "vendor" / "old").write_text("old")
        (self.public / "storage").mkdir()
        (self.public / "storage" / "photo.jpg").write_text("customer upload")
        (self.public / "index.php").write_text("live")
        for filename in ("auto-update.sh", "backup-database.php"):
            shutil.copy(ROOT / "deploy" / filename, self.deploy)
        self.env = dict(os.environ, APP_ROOT=str(self.app), PUBLIC_ROOT=str(self.public),
                        HEALTH_URL="https://example.test/up", NODE_BIN=str(self.bin),
                        TEST_CALLS=str(self.root / "calls"), TEST_ROOT=str(self.root))
        stub = '''#!/usr/bin/env python3
import os, pathlib, sys
name = pathlib.Path(sys.argv[0]).name
args = sys.argv[1:]
root = pathlib.Path(os.environ['TEST_ROOT'])
with open(os.environ['TEST_CALLS'], 'a') as log:
    log.write(name + ' ' + ' '.join(args) + '\\n')
if name == 'composer':
    pathlib.Path('vendor').mkdir(exist_ok=True)
    pathlib.Path('vendor/new').write_text('new')
    if args[:2] == ['run-script', 'post-autoload-dump']:
        (root / 'stale-providers').unlink(missing_ok=True)
if name == 'rsync' and any(arg.endswith('/vendor/') for arg in args):
    (root / 'stale-providers').touch()
if name == 'php' and args[0] == 'artisan' and (root / 'stale-providers').exists():
    sys.exit(10)  # Old cached providers reference removed development packages.
if name == 'npm' and args == ['run', 'build']:
    if (root / 'fail-build').exists(): sys.exit(7)
    pathlib.Path('public/build').mkdir(parents=True, exist_ok=True)
    pathlib.Path('public/build/manifest.json').write_text('{}')
if name == 'php' and args[0].endswith('backup-database.php'):
    if (root / 'fail-backup').exists(): sys.exit(9)
    pathlib.Path(args[2]).write_text('SQL backup')
if name == 'php' and args[:2] == ['artisan', 'migrate'] and (root / 'fail-migration').exists():
    sys.exit(8)
if name == 'curl':
    print('500' if (root / 'fail-health').exists() else '200', end='')
'''
        for name in ("php", "composer", "npm", "node", "mysqldump", "curl", "rsync"):
            executable = self.bin / name
            executable.write_text(stub)
            executable.chmod(0o755)

    def git(self, *args, cwd=None):
        return subprocess.check_output(["git", *args], cwd=cwd or self.root,
                                       stderr=subprocess.DEVNULL, text=True).strip()

    def commit(self, message):
        self.git("add", ".", cwd=self.source)
        self.git("-c", "user.name=Deployment test", "-c", "user.email=test@example.test",
                 "commit", "-m", message, cwd=self.source)
        self.git("push", "origin", "main", cwd=self.source)

    def update(self):
        (self.source / "new.txt").write_text("new release")
        self.commit("update")
        return self.git("rev-parse", "HEAD", cwd=self.source)

    def run_deploy(self, *args):
        return subprocess.run(["bash", str(self.deploy / "auto-update.sh"), *args],
                              env=self.env, capture_output=True, text=True, timeout=20)

    def calls(self):
        return (self.root / "calls").read_text() if (self.root / "calls").exists() else ""

    def test_fast_forward_migrates_then_marks_success_and_next_poll_is_noop(self):
        target = self.update()
        result = self.run_deploy()
        self.assertEqual(result.returncode, 0, result.stdout + result.stderr)
        self.assertEqual(self.git("rev-parse", "HEAD", cwd=self.app), target)
        self.assertEqual((self.deploy / "state/last-success").read_text().strip(), target)
        calls = self.calls()
        self.assertLess(calls.index("backup-database.php"), calls.index("artisan migrate --force"))
        self.assertIn("artisan queue:restart", calls)
        self.assertEqual((self.public / "storage/photo.jpg").read_text(), "customer upload")
        self.assertEqual(self.run_deploy().returncode, 0)
        self.assertEqual(self.calls(), calls)

    def test_failed_build_leaves_live_code_online_and_does_not_retry_same_commit(self):
        before = self.git("rev-parse", "HEAD", cwd=self.app)
        self.update()
        (self.root / "fail-build").touch()
        self.assertNotEqual(self.run_deploy().returncode, 0)
        self.assertEqual(self.git("rev-parse", "HEAD", cwd=self.app), before)
        self.assertNotIn("artisan down", self.calls())
        calls = self.calls()
        self.assertEqual(self.run_deploy().returncode, 0)
        self.assertEqual(self.calls(), calls)

    def test_failed_migration_requires_explicit_recovery_even_after_another_push(self):
        self.update()
        (self.root / "fail-migration").touch()
        self.assertNotEqual(self.run_deploy().returncode, 0)
        self.assertTrue((self.deploy / "state/needs-recovery").exists())
        self.assertFalse((self.deploy / "state/last-success").exists())
        self.assertNotIn("artisan up", self.calls())
        (self.source / "fix.txt").touch()
        self.commit("fix")
        calls = self.calls()
        self.assertEqual(self.run_deploy().returncode, 0)
        self.assertEqual(self.calls(), calls)
        (self.root / "fail-migration").unlink()
        result = self.run_deploy("--retry")
        self.assertEqual(result.returncode, 0, result.stdout + result.stderr)
        self.assertFalse((self.deploy / "state/needs-recovery").exists())

    def test_uncommitted_server_changes_are_preserved(self):
        self.update()
        (self.app / "artisan").write_text("server edit")
        self.assertNotEqual(self.run_deploy().returncode, 0)
        self.assertEqual((self.app / "artisan").read_text(), "server edit")
        self.assertEqual(self.calls(), "")

    def test_failed_http_check_does_not_record_a_success(self):
        self.update()
        (self.root / "fail-health").touch()
        self.assertNotEqual(self.run_deploy().returncode, 0)
        self.assertTrue((self.deploy / "state/needs-recovery").exists())
        self.assertFalse((self.deploy / "state/last-success").exists())

    def test_check_only_fetches_and_reports_without_deploying(self):
        target = self.update()
        result = self.run_deploy("--check")
        self.assertEqual(result.returncode, 0)
        self.assertIn(target, result.stdout)
        self.assertEqual(self.calls(), "")

    def test_failed_backup_restores_availability_without_updating_code(self):
        before = self.git("rev-parse", "HEAD", cwd=self.app)
        self.update()
        (self.root / "fail-backup").touch()
        self.assertNotEqual(self.run_deploy().returncode, 0)
        self.assertEqual(self.git("rev-parse", "HEAD", cwd=self.app), before)
        self.assertIn("artisan up", self.calls())
        self.assertNotIn("artisan migrate", self.calls())
        self.assertFalse((self.deploy / "state/needs-recovery").exists())

    def test_a_second_runner_cannot_overlap_an_existing_deployment(self):
        self.update()
        (self.deploy / "state").mkdir()
        with (self.deploy / "state/deploy.lock").open("w") as lock:
            fcntl.flock(lock, fcntl.LOCK_EX | fcntl.LOCK_NB)
            self.assertEqual(self.run_deploy().returncode, 0)
            self.assertEqual(self.calls(), "")

    def test_diverged_history_is_not_reset(self):
        self.update()
        (self.app / "server.txt").touch()
        self.git("add", "server.txt", cwd=self.app)
        self.git("-c", "user.name=Deployment test", "-c", "user.email=test@example.test",
                 "commit", "-m", "server change", cwd=self.app)
        before = self.git("rev-parse", "HEAD", cwd=self.app)
        self.assertNotEqual(self.run_deploy().returncode, 0)
        self.assertEqual(self.git("rev-parse", "HEAD", cwd=self.app), before)
        self.assertEqual(self.calls(), "")


if __name__ == "__main__":
    unittest.main()
