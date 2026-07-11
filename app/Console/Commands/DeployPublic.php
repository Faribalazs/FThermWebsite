<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class DeployPublic extends Command
{
    protected $signature = 'deploy:public
        {--path= : Absolute public_html path (default: sibling public_html)}
        {--skip-build : Use the existing public/build files}
        {--no-optimize : Do not rebuild Laravel production caches}';

    protected $description = 'Build frontend assets and deploy Laravel public files to public_html';

    public function handle(Filesystem $files): int
    {
        $appRoot = base_path();
        $target = $this->option('path') ?: dirname($appRoot).DIRECTORY_SEPARATOR.'public_html';
        $target = rtrim($target, DIRECTORY_SEPARATOR);

        if (! str_starts_with($target, DIRECTORY_SEPARATOR)) {
            $this->error('The --path option must be an absolute path.');
            return self::FAILURE;
        }

        if ($target === $appRoot || str_starts_with($target, $appRoot.DIRECTORY_SEPARATOR)) {
            $this->error('public_html must be outside the Laravel application directory.');
            return self::FAILURE;
        }

        $storageLink = $target.DIRECTORY_SEPARATOR.'storage';
        if (file_exists($storageLink) && ! is_link($storageLink)) {
            $this->error("{$storageLink} exists and is not a symbolic link.");
            $this->line('Move or remove that directory manually, then run the command again.');
            return self::FAILURE;
        }

        $this->components->info("Application: {$appRoot}");
        $this->components->info("Public root: {$target}");

        if (! $this->option('skip-build')) {
            if (! $this->runProcess(['npm', 'run', 'build'], $appRoot, 'Building Vite assets')) {
                return self::FAILURE;
            }
        } elseif (! $files->exists(public_path('build/manifest.json'))) {
            $this->error('No existing Vite build was found at public/build/manifest.json.');
            return self::FAILURE;
        }

        $files->ensureDirectoryExists($target, 0755, true);
        $this->components->task('Copying public files', function () use ($files, $target): void {
            $this->copyPublicDirectory($files, public_path(), $target);
        });
        if ($files->exists(public_path('.htaccess'))) {
            $files->copy(public_path('.htaccess'), $target.DIRECTORY_SEPARATOR.'.htaccess');
        }

        $template = $files->get(base_path('deploy/public-html-index.php'));
        $index = str_replace('__APP_ROOT__', var_export(base_path(), true), $template);
        $files->put($target.DIRECTORY_SEPARATOR.'index.php', $index);
        chmod($target.DIRECTORY_SEPARATOR.'index.php', 0644);

        $storageTarget = storage_path('app/public');
        $files->ensureDirectoryExists($storageTarget, 0755, true);
        if (is_link($storageLink)) {
            unlink($storageLink);
        }

        if (! symlink($storageTarget, $storageLink)) {
            $this->error('Unable to create the public_html/storage symbolic link.');
            return self::FAILURE;
        }

        if (! $this->option('no-optimize')) {
            $this->call('optimize');
        }

        $this->newLine();
        $this->components->info('Public deployment completed successfully.');
        $this->line("Storage: {$storageLink} -> {$storageTarget}");

        return self::SUCCESS;
    }

    private function copyPublicDirectory(Filesystem $files, string $source, string $target): void
    {
        foreach ($files->allFiles($source, true) as $file) {
            $relativePath = $file->getRelativePathname();
            $firstSegment = explode(DIRECTORY_SEPARATOR, $relativePath)[0];

            if (in_array($firstSegment, ['index.php', 'storage', 'hot'], true)) {
                continue;
            }

            $destination = $target.DIRECTORY_SEPARATOR.$relativePath;
            $files->ensureDirectoryExists(dirname($destination), 0755, true);
            $files->copy($file->getPathname(), $destination);
        }
    }

    private function runProcess(array $command, string $directory, string $label): bool
    {
        return (bool) $this->components->task($label, function () use ($command, $directory): bool {
            $process = new Process($command, $directory, null, null, 600);
            $process->run();

            if (! $process->isSuccessful()) {
                $this->newLine();
                $this->error(trim($process->getErrorOutput() ?: $process->getOutput()));
                return false;
            }

            return true;
        });
    }
}
