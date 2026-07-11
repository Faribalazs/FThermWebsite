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

If `public_html/storage` is a real directory instead of a symbolic link, deployment stops without replacing it. Move its files into `storage/app/public`, remove the old directory manually, and run deployment again.

Do not use `php artisan storage:link` for this cPanel layout. Laravel's `public` directory is not the live document root; `deploy:public` creates the link in the correct `public_html` directory.

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
