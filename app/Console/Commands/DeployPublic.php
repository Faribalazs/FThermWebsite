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
        {--no-optimize : Do not rebuild Laravel production caches}
        {--storage-mode=auto : Storage publishing mode: auto, link, or copy}';

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
        $storageMode = strtolower((string) $this->option('storage-mode'));
        if (! in_array($storageMode, ['auto', 'link', 'copy'], true)) {
            $this->error('The --storage-mode option must be auto, link, or copy.');
            return self::FAILURE;
        }

        $this->components->info("Application: {$appRoot}");
        $this->components->info("Public root: {$target}");

        if (! $this->verifySeoTemplates($files)) {
            return self::FAILURE;
        }

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

        if (! $this->verifyPublicDeployment($files, $target)) {
            return self::FAILURE;
        }

        $storageTarget = storage_path('app/public');
        $files->ensureDirectoryExists($storageTarget, 0755, true);
        $publishedStorageMode = $this->publishStorage($files, $storageTarget, $storageLink, $storageMode);
        if ($publishedStorageMode === null) {
            return self::FAILURE;
        }

        if (! $this->option('no-optimize')) {
            $this->call('optimize');
        }

        $this->newLine();
        $this->components->info('Public deployment completed successfully.');
        $this->line('SEO discovery: robots.txt copied; sitemap.xml and llms.txt are served by Laravel through index.php.');
        if ($publishedStorageMode === 'link') {
            $this->line("Storage link: {$storageLink} -> {$storageTarget}");
        } else {
            $this->line("Storage copy: {$storageTarget} -> {$storageLink}");
            $this->components->warn('The server did not use a symbolic link. Run deploy:public again after new uploads to resync files, or set PUBLIC_STORAGE_PATH to the public_html/storage directory.');
        }

        return self::SUCCESS;
    }

    private function publishStorage(
        Filesystem $files,
        string $source,
        string $destination,
        string $mode
    ): ?string {
        if ($mode !== 'copy') {
            if (is_link($destination) && realpath($destination) === realpath($source)) {
                return 'link';
            }

            if (is_link($destination)) {
                unlink($destination);
            }

            if (! file_exists($destination) && @symlink($source, $destination) && is_link($destination)) {
                return 'link';
            }

            if ($mode === 'link') {
                $this->error("Unable to create symbolic link: {$destination} -> {$source}");
                $this->line('Your hosting may have disabled the PHP symlink() function. Use --storage-mode=copy.');
                return null;
            }
        }

        if (is_link($destination)) {
            unlink($destination);
        }

        $files->ensureDirectoryExists($destination, 0755, true);
        if (! $files->copyDirectory($source, $destination)) {
            $this->error("Unable to copy public storage to {$destination}.");
            return null;
        }

        return 'copy';
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

    private function verifyPublicDeployment(Filesystem $files, string $target): bool
    {
        $requiredFiles = [
            '.htaccess',
            'index.php',
            'robots.txt',
            'build/manifest.json',
            'images/logo.svg',
        ];

        $missingFiles = collect($requiredFiles)
            ->reject(fn (string $path) => $files->isFile($target.DIRECTORY_SEPARATOR.$path))
            ->values();

        if ($missingFiles->isNotEmpty()) {
            $this->error('Deployment is incomplete. Required public/SEO files are missing from public_html:');
            $missingFiles->each(fn (string $path) => $this->line(" - {$path}"));

            return false;
        }

        $htaccess = $files->get($target.DIRECTORY_SEPARATOR.'.htaccess');
        if (! str_contains($htaccess, 'RewriteRule ^ index.php')) {
            $this->error('The deployed .htaccess does not route sitemap.xml and llms.txt through Laravel.');

            return false;
        }

        $this->components->info('Verified public assets and SEO discovery entry points.');

        return true;
    }

    private function verifySeoTemplates(Filesystem $files): bool
    {
        $unsafeTemplates = collect($files->allFiles(resource_path('views')))
            ->filter(fn ($file) => $file->getExtension() === 'php')
            ->filter(fn ($file) => str_contains($files->get($file->getPathname()), "'@context'"))
            ->map(fn ($file) => $file->getRelativePathname())
            ->values();

        if ($unsafeTemplates->isNotEmpty()) {
            $this->error('Unsafe JSON-LD @context keys found. Blade may compile them as directives:');
            $unsafeTemplates->each(fn (string $path) => $this->line(" - resources/views/{$path}"));

            return false;
        }

        $this->components->info('Verified Blade-safe JSON-LD templates.');

        return true;
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
