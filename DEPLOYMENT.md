# FTHERM cPanel Deployment

This document explains how to deploy the Laravel application to `public_html` with the custom Artisan command.

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

## Server requirements

- PHP 8.2+
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