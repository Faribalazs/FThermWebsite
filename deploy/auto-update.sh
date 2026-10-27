#!/usr/bin/env bash
# Install this script and backup-database.php outside the live Git checkout.
set -Eeuo pipefail
umask 022

DEPLOY_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
if [[ -f "$DEPLOY_DIR/config.env" ]]; then
    source "$DEPLOY_DIR/config.env"
fi
: "${APP_ROOT:?Set APP_ROOT in config.env}"
: "${PUBLIC_ROOT:?Set PUBLIC_ROOT in config.env}"
: "${HEALTH_URL:?Set HEALTH_URL in config.env}"
BRANCH="${BRANCH:-main}"
export PATH="${NODE_BIN:-/opt/alt/alt-nodejs22/root/usr/bin}:/usr/local/bin:/usr/local/cpanel/3rdparty/lib/path-bin:/usr/bin:/bin:$PATH"
export GIT_TERMINAL_PROMPT=0
export COMPOSER_NO_INTERACTION=1
MODE="${1:-}"
case "$MODE" in ''|--check|--force|--retry) ;; *) echo 'Usage: auto-update.sh [--check|--force|--retry]' >&2; exit 2 ;; esac

mkdir -p "$DEPLOY_DIR/state" "$DEPLOY_DIR/logs" "$DEPLOY_DIR/backups"
chmod 700 "$DEPLOY_DIR" "$DEPLOY_DIR/state" "$DEPLOY_DIR/logs" "$DEPLOY_DIR/backups"
exec 9>"$DEPLOY_DIR/state/deploy.lock"
flock -n 9 || exit 0
[[ ! -f "$DEPLOY_DIR/state/paused" ]] || exit 0
if [[ -f "$DEPLOY_DIR/state/needs-recovery" && "$MODE" != --retry && "$MODE" != --check ]]; then
    exit 0
fi

cd "$APP_ROOT"
[[ "$(git branch --show-current)" == "$BRANCH" ]] || { echo "Expected branch $BRANCH" >&2; exit 1; }
[[ -z "$(git status --porcelain)" ]] || { echo 'Live checkout has local changes; refusing to overwrite them.' >&2; exit 1; }
timeout 90 git fetch --quiet origin "refs/heads/$BRANCH"
TARGET="$(git rev-parse FETCH_HEAD)"
CURRENT="$(git rev-parse HEAD)"
git merge-base --is-ancestor "$CURRENT" "$TARGET" || { echo 'Remote history is not a fast-forward; manual review required.' >&2; exit 1; }
if [[ "$MODE" == --check ]]; then
    printf 'Branch: %s\nLive: %s\nRemote: %s\n' "$BRANCH" "$CURRENT" "$TARGET"
    [[ ! -f "$DEPLOY_DIR/state/needs-recovery" ]] || echo 'Manual recovery is required.'
    exit 0
fi
if [[ "$MODE" != --force && "$MODE" != --retry ]]; then
    [[ ! -f "$DEPLOY_DIR/state/failed-commit" || "$(cat "$DEPLOY_DIR/state/failed-commit")" != "$TARGET" ]] || exit 0
    [[ "$CURRENT" != "$TARGET" || ! -f "$DEPLOY_DIR/state/last-success" || "$(cat "$DEPLOY_DIR/state/last-success")" != "$TARGET" ]] || exit 0
fi

RUN="$(date -u +%Y%m%dT%H%M%SZ)-${TARGET:0:12}"
LOG="$DEPLOY_DIR/logs/$RUN.log"
echo "Deployment log: $LOG"
# cPanel CageFS may not expose /dev/fd, so do not use process substitution.
exec >> "$LOG" 2>&1
STAGE=''
TOUCHED_LIVE=0
MAINTENANCE=0
finish() {
    result=$?
    trap - EXIT
    if [[ "$result" -ne 0 ]]; then
        printf '%s\n' "$TARGET" > "$DEPLOY_DIR/state/failed-commit"
        printf '%s FAILED (exit %s). Log: %s\n' "$RUN" "$result" "$LOG" > "$DEPLOY_DIR/state/status"
        if [[ "$TOUCHED_LIVE" == 1 ]]; then
            touch "$DEPLOY_DIR/state/needs-recovery"
            php artisan down --retry=60 --no-interaction || true
            echo 'FAILED: live changes started; maintenance remains enabled. Review the log and backup before --retry.'
        elif [[ "$MAINTENANCE" == 1 ]]; then
            php artisan up --no-interaction || true
        fi
        echo "Deployment failed. Log: $LOG"
    fi
    [[ -z "$STAGE" ]] || rm -rf -- "$STAGE"
    exit "$result"
}
trap finish EXIT
trap 'exit 130' INT
trap 'exit 143' TERM

echo "[$RUN] Deploying $CURRENT -> $TARGET"
for binary in php composer node npm rsync mysqldump curl; do command -v "$binary" >/dev/null; done
[[ -f .env && -f artisan && -d "$PUBLIC_ROOT" ]]
[[ "$PUBLIC_ROOT" != "$APP_ROOT" && "$PUBLIC_ROOT" != "$APP_ROOT/"* ]]
if [[ -f storage/framework/down && !( "$MODE" == --retry && -f "$DEPLOY_DIR/state/needs-recovery" ) ]]; then
    echo 'The application is already in maintenance mode; leaving it unchanged.' >&2
    exit 1
fi
# This host stores uploads directly in public_html/storage. Never overwrite them
# with the legacy storage/app/public copy during an automatic deployment.
php -r '
    require "vendor/autoload.php";
    $app = require "bootstrap/app.php";
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    if (realpath(config("filesystems.disks.public.root")) !== realpath($argv[1]."/storage") || !is_dir($argv[1]."/storage")) {
        fwrite(STDERR, "Public storage does not match the live uploads directory. Review configuration first.\n");
        exit(1);
    }
' "$PUBLIC_ROOT"

STAGE="$(mktemp -d "$DEPLOY_DIR/stage.XXXXXXXX")"
git archive "$TARGET" | tar -x -C "$STAGE"
[[ -f "$STAGE/composer.lock" && -f "$STAGE/package-lock.json" ]]
echo 'Preparing Composer dependencies and frontend assets before maintenance...'
(
    cd "$STAGE"
    composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-progress --no-scripts
    npm ci --no-audit --no-fund
    npm run build
    test -s public/build/manifest.json
)

# Recheck after the build in case somebody edited or deployed the live checkout.
[[ "$(git rev-parse HEAD)" == "$CURRENT" && -z "$(git status --porcelain)" ]]
BACKUP="$DEPLOY_DIR/backups/$RUN"
mkdir -m 700 "$BACKUP"
git archive "$CURRENT" | gzip > "$BACKUP/source.tar.gz"
tar -czf "$BACKUP/vendor.tar.gz" vendor
tar -czf "$BACKUP/public.tar.gz" --exclude='./storage' --exclude='./.well-known' -C "$PUBLIC_ROOT" .
printf '%s\n' "$CURRENT" > "$BACKUP/commit"
MAINTENANCE=1
php artisan down --retry=60 --no-interaction
php "$DEPLOY_DIR/backup-database.php" "$APP_ROOT" "$BACKUP/database.sql"
[[ -s "$BACKUP/database.sql" ]]

TOUCHED_LIVE=1
git merge --ff-only "$TARGET"
rsync -a --delete "$STAGE/vendor/" "$APP_ROOT/vendor/"
mkdir -p "$APP_ROOT/public/build"
rsync -a --delete "$STAGE/public/build/" "$APP_ROOT/public/build/"
# Clear cached providers before Artisan boots: old manifests may reference
# development packages removed by the production-only Composer installation.
composer run-script post-autoload-dump --no-dev --no-interaction
php artisan migrate --force --no-interaction
php artisan optimize:clear --no-interaction
php artisan optimize --no-interaction

# Preserve uploads, ACME verification files and older hashed assets for open tabs.
rsync -a --exclude='/index.php' --exclude='/storage' --exclude='/hot' --exclude='/.well-known' "$APP_ROOT/public/" "$PUBLIC_ROOT/"
php -r '
    $template = file_get_contents($argv[1]."/deploy/public-html-index.php");
    if ($template === false || !str_contains($template, "__APP_ROOT__")) { exit(1); }
    $index = str_replace("__APP_ROOT__", var_export($argv[1], true), $template);
    $temp = $argv[2]."/index.php.deploy-tmp";
    if (file_put_contents($temp, $index) === false || !chmod($temp, 0644) || !rename($temp, $argv[2]."/index.php")) { exit(1); }
' "$APP_ROOT" "$PUBLIC_ROOT"
php artisan queue:restart --no-interaction
php artisan up --no-interaction
MAINTENANCE=0
for url in "$HEALTH_URL" "${SMOKE_URL:-$HEALTH_URL}"; do
    code="$(curl --silent --show-error --output /dev/null --write-out '%{http_code}' --max-time 30 --retry 2 --retry-delay 2 --header 'Cache-Control: no-cache' "$url")"
    [[ "$code" == 200 ]] || { echo "Health check failed: $url returned $code" >&2; exit 1; }
done
printf '%s\n' "$TARGET" > "$DEPLOY_DIR/state/last-success"
rm -f "$DEPLOY_DIR/state/failed-commit" "$DEPLOY_DIR/state/needs-recovery"
printf '%s SUCCESS %s\n' "$RUN" "$TARGET" > "$DEPLOY_DIR/state/status"
echo "SUCCESS: $TARGET deployed, migrations completed, HTTPS health checks passed."
echo "Backup: $BACKUP"
