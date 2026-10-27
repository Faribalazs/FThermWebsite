# FTHERM cPanel Deployment

This document explains how to deploy the Laravel application to `public_html` with the custom Artisan command.

## Automatic deployment on this server

Enabled and verified on 2026-10-27. A full deployment of `9c6bef00f713` completed successfully,
including the database backup, migration check, cache rebuild and HTTPS checks for `/up` and `/sr`.
The first independent cron run was also verified.

The production server polls `origin/main` every minute. Pushes to other branches do not deploy.
The runner is installed outside the checkout at `/home/fthermrs/deploy-ftherm`, so updating
application code cannot interrupt the script that is currently running.

```cron
* * * * * /bin/bash /home/fthermrs/deploy-ftherm/auto-update.sh >> /home/fthermrs/deploy-ftherm/cron.log 2>&1
```

Each new commit is fetched using the server's existing GitHub access. The runner:

1. Requires a clean `main` checkout and a fast-forward update, and takes an exclusive lock.
2. Installs production Composer dependencies and runs `npm ci` / `npm run build` in a temporary directory with Node 22.
3. Saves the previous source, vendor directory and public files in a private backup directory.
4. Enables maintenance mode and creates a MySQL dump before running any migration.
5. Updates the code and dependencies, runs `migrate --force`, clears/rebuilds Laravel caches,
   publishes the frontend and signals queue workers to restart.
6. Disables maintenance mode, checks `/up` and `/sr` over HTTPS, and records the successful commit.

The production `.env`, application key and uploaded files are preserved. This host uses
`PUBLIC_STORAGE_PATH=/home/fthermrs/public_html/storage`; the runner verifies that storage
configuration and never copies the old `storage/app/public` files over current uploads.
It never runs `migrate:fresh`, `migrate:refresh`, seeders or automatic database rollbacks.
There are currently no scheduled application tasks or queued application jobs to configure.
`queue:restart` signals existing workers; it does not create a worker service.

### Status and recovery

```bash
cat /home/fthermrs/deploy-ftherm/state/status
tail -n 100 /home/fthermrs/deploy-ftherm/logs/*.log
/bin/bash /home/fthermrs/deploy-ftherm/auto-update.sh --check
```

If preparation fails, the live site remains unchanged. The same failed commit is not retried
every minute; push a fix or use `--retry` after correcting the cause. If a failure occurs after
live changes begin, maintenance mode stays enabled and automatic deployment stops, including
for newer commits. Review the log and backup, fix the cause, then explicitly retry:

```bash
/bin/bash /home/fthermrs/deploy-ftherm/auto-update.sh --retry
```

Do not simply run `artisan up` after a failed migration: the schema and code must first be
checked for compatibility. MySQL migrations can partly apply before failing. Recovery backups
are in `/home/fthermrs/deploy-ftherm/backups/<timestamp>-<commit>/`; they include `database.sql`,
`source.tar.gz`, `vendor.tar.gz`, `public.tar.gz` and the previous commit hash. Uploaded files and
`.env` are not duplicated by this deployment backup. Backups are retained until manually pruned.

Pause/resume automatic polling without editing the cron entry:

```bash
touch /home/fthermrs/deploy-ftherm/state/paused
rm /home/fthermrs/deploy-ftherm/state/paused
```

To redeploy the current commit, use `--force` (a failed live deployment still requires `--retry`).

### Installing or updating the runner

Copy `deploy/auto-update.sh`, `deploy/backup-database.php` and a configured copy of
`deploy/config.env.example` into `/home/fthermrs/deploy-ftherm` as `config.env`.
Keep this directory private (`chmod 700`) and the config private (`chmod 600`). Runner changes
in Git are **not** automatically copied into that directory; install them separately after review.
Run `--check`, then `--force` to verify a full deployment before enabling the cron entry.

Local deployment tests use temporary Git repositories and stubbed services:

```bash
python3 -m unittest discover -s tests/Deployment -v
```

## Server structure

```text
/home/fthermrs/
├── FThermWebsiteNew/   # Complete Laravel application
└── public_html/        # Public website document root
```

Keep `.env`, `vendor`, `storage`, and all private Laravel files inside `FThermWebsiteNew`. Only publicly accessible files belong in `public_html`.

## First deployment

Configure `/home/fthermrs/FThermWebsiteNew/.env`:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ftherm.rs
```

Install dependencies and migrate the database:

```bash
cd /home/fthermrs/FThermWebsiteNew
composer install --optimize-autoloader --no-dev
php artisan migrate --force
```

Deploy the public website:

```bash
php artisan deploy:public
```

## What the command does

- Runs `npm run build` for production Vite assets.
- Copies files from `public/` to `/home/fthermrs/public_html`.
- Copies `.htaccess`, images, CSS, JavaScript, `robots.txt`, and other public assets.
- Generates `public_html/index.php` configured to load the Laravel application from `FThermWebsiteNew`.
- Verifies that `.htaccess`, `index.php`, `robots.txt`, the Vite manifest, and the FTHERM logo exist in `public_html`.
- Keeps `sitemap.xml` and `llms.txt` dynamic: Apache sends those requests through `public_html/index.php` to Laravel, so they always reflect current services and references.
- Creates this storage link:

```text
/home/fthermrs/public_html/storage
→ /home/fthermrs/FThermWebsiteNew/storage/app/public
```

- Runs `php artisan optimize`.

## Public storage and uploaded images

By default, deployment tries to create this symbolic link:

```text
/home/fthermrs/public_html/storage
→ /home/fthermrs/FThermWebsiteNew/storage/app/public
```

If cPanel blocks symbolic links, the command automatically copies and synchronizes the files instead. You can explicitly select either mode:

```bash
php artisan deploy:public --skip-build --storage-mode=link
php artisan deploy:public --skip-build --storage-mode=copy
```

This command copies all static SEO assets from `public/` to `public_html`, including `robots.txt`, images, favicons and compiled CSS/JavaScript. It also verifies the rewrite/front-controller files needed for these live URLs:

```text
https://ftherm.rs/robots.txt
https://ftherm.rs/sitemap.xml
https://ftherm.rs/llms.txt
```

When copy mode is used, run the deployment command again to synchronize images uploaded after the previous deployment:

```bash
php artisan deploy:public --skip-build --no-optimize --storage-mode=copy
```

For uploads to be written directly into `public_html/storage` on servers that do not permit symbolic links, add this to the production `.env`:

```dotenv
PUBLIC_STORAGE_PATH=/home/fthermrs/public_html/storage
```

Then clear the cached configuration:

```bash
php artisan config:clear
php artisan deploy:public --skip-build --storage-mode=copy
```

## Subsequent deployments

```bash
cd /home/fthermrs/FThermWebsiteNew
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan deploy:public
```

## Command options

Use an existing `public/build` without running Node.js:

```bash
php artisan deploy:public --skip-build
```

The compiled build must exist at `public/build/manifest.json`.

Deploy to another absolute document-root path:

```bash
php artisan deploy:public --path=/absolute/path/to/public_html
```

Skip rebuilding Laravel caches:

```bash
php artisan deploy:public --no-optimize
```

Combine options when needed:

```bash
php artisan deploy:public --skip-build --no-optimize
```

## Storage-link safety

If `public_html/storage` is a real directory, automatic mode synchronizes files into it. It no longer stops deployment.

Do not use `php artisan storage:link` for this cPanel layout. Laravel's `public` directory is not the live document root; `deploy:public` publishes storage in the correct `public_html` directory.

## PHP security updates

The minimum supported patch versions are **8.2.35, 8.3.36, 8.4.27, and 8.5.12**.
These contain the fixes for CVE-2026-109618 and CVE-2026-109619, announced in the
[PHP security advisory on 21 October 2026](https://www.php.net/archive/2026.php).
Composer rejects older patch versions in each branch; changing `composer.json` does
not install or upgrade the PHP runtime itself.

Verified on 2026-10-27: the live LiteSpeed response and CLI both reported PHP 8.2.35,
production Composer platform checks passed, and `/up`, `/sr`, `/sr/contact`, and
`/admin/login` returned HTTP 200. The provider had already applied the patch; no
production runtime change was needed. The CLI also reported
`session.upload_progress.enabled=0` and `session.serialize_handler=php`.

Check both the website's PHP handler and the CLI used by cron/Composer. A PHP
Selector label such as `8.2` only identifies the branch, not its patch version.
On this host, check the selected runtime's full version in the cPanel Terminal:

```bash
php -v
composer check-platform-reqs --no-dev
```

The hosting provider installs patch releases. If a patch update leaves old PHP
workers running, restart the affected workers through the hosting controls or ask
the provider to do so. After an update, verify `/up`, `/sr`, `/sr/contact`, and the
admin login. Keep the website and deployment CLI on patched runtimes.

PHP 8.2 reaches end of upstream security support on 31 December 2026. Plan a tested
upgrade to a newer supported branch before that date.

For the local Ubuntu development environment, the configured PHP package repository
provides 8.2.35. Updating the system installation requires administrator access:

```bash
sudo apt-get update
sudo apt-get install --only-upgrade php8.2-cli php8.2-common php8.2-bz2 php8.2-curl php8.2-gd php8.2-mbstring php8.2-mysql php8.2-opcache php8.2-phpdbg php8.2-readline php8.2-xml php8.2-zip
php -v
```

Restart any development server after updating, so it uses the patched binary.
Do not bypass Composer's PHP version check with `--ignore-platform-reqs`.

## Server requirements

- PHP 8.2.35+, 8.3.36+, 8.4.27+, or 8.5.12+ (latest security patch in the selected branch)
- MySQL 5.7+ or MariaDB 10.3+
- Apache with `mod_rewrite`
- Composer
- Node.js and NPM, or an existing `public/build` directory

## Permissions

```bash
chmod -R 775 storage bootstrap/cache
```

Public directories normally use `755` and public files use `644`.

## Troubleshooting

### Storage files are unavailable

```bash
chmod -R 775 storage bootstrap/cache
php artisan deploy:public --skip-build
```

### Compiled assets are unavailable

```bash
php artisan deploy:public
```

If Node.js is unavailable, build locally, upload `public/build`, and run:

```bash
php artisan deploy:public --skip-build
```

### Clear stale Laravel caches

```bash
php artisan optimize:clear
php artisan deploy:public --skip-build
```
Ezt kell futtatni:

php artisan config:clear
php artisan deploy:public --skip-build --storage-mode=copy


## Reference videos and optimized uploads

- Run `php artisan migrate --force` when deploying the reference video feature. The automatic deployment runner already does this. The additive migration creates `gallery_videos`; existing photos are unchanged.
- Admin → Reference → Edit now accepts one MP4 or WebM video per upload, up to 50 MiB. MP4 with H.264 is recommended; uploads are stored as supplied, without server-side video transcoding. Public players use controls, inline playback and `preload="none"`.
- `public/.user.ini` requests a 64 MiB per-file and 128 MiB total POST limit. Publish this hidden file into the document root as well. If the PHP handler ignores `.user.ini`, apply the same limits in cPanel's PHP settings; any web-server/proxy body limit must also permit these uploads.
- All existing admin image upload forms use `WebpImageStorage`: WebP quality 82, maximum long edge 2048 px, proportional resizing without upscaling, alpha preservation, and JPEG EXIF orientation when PHP EXIF is enabled. PHP GD must include WebP support. This applies to new uploads; existing files are not rewritten.
- Targeted checks: `php artisan test tests/Feature/WebpImageStorageTest.php tests/Feature/GalleryMediaTest.php` and `npm run build`. Database tests require PDO SQLite.
