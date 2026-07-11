#!/usr/bin/env bash

set -Eeuo pipefail

APP_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PUBLIC_HTML="${1:-$(dirname "$APP_ROOT")/public_html}"

if [[ "$PUBLIC_HTML" != /* ]]; then
    PUBLIC_HTML="$(pwd)/$PUBLIC_HTML"
fi

if [[ ! -f "$APP_ROOT/artisan" || ! -f "$APP_ROOT/public/index.php" ]]; then
    echo "Error: Laravel application files were not found in $APP_ROOT" >&2
    exit 1
fi

if [[ "$PUBLIC_HTML" == "$APP_ROOT" || "$PUBLIC_HTML" == "$APP_ROOT"/* ]]; then
    echo "Error: public_html must be outside the Laravel application directory." >&2
    exit 1
fi

echo "Laravel application: $APP_ROOT"
echo "Public document root: $PUBLIC_HTML"

if command -v npm >/dev/null 2>&1; then
    echo "Building frontend assets..."
    if [[ -f "$APP_ROOT/package-lock.json" ]]; then
        npm --prefix "$APP_ROOT" ci
    else
        npm --prefix "$APP_ROOT" install
    fi
    npm --prefix "$APP_ROOT" run build
elif [[ ! -f "$APP_ROOT/public/build/manifest.json" ]]; then
    echo "Error: npm is unavailable and public/build/manifest.json does not exist." >&2
    exit 1
else
    echo "npm is unavailable; using the existing frontend build."
fi

mkdir -p "$PUBLIC_HTML"

echo "Copying public files..."
if command -v rsync >/dev/null 2>&1; then
    rsync -a --delete \
        --exclude='index.php' \
        --exclude='storage' \
        --exclude='hot' \
        "$APP_ROOT/public/" "$PUBLIC_HTML/"
else
    echo "Error: rsync is required to safely synchronize public_html." >&2
    exit 1
fi

php -r '
    $template = file_get_contents($argv[1]);
    $index = str_replace("__APP_ROOT__", var_export($argv[2], true), $template);
    if (file_put_contents($argv[3], $index) === false) {
        fwrite(STDERR, "Unable to write deployed index.php\n");
        exit(1);
    }
' "$APP_ROOT/deploy/public-html-index.php" "$APP_ROOT" "$PUBLIC_HTML/index.php"

STORAGE_LINK="$PUBLIC_HTML/storage"
STORAGE_TARGET="$APP_ROOT/storage/app/public"

mkdir -p "$STORAGE_TARGET"

if [[ -e "$STORAGE_LINK" && ! -L "$STORAGE_LINK" ]]; then
    echo "Error: $STORAGE_LINK exists and is not a symbolic link." >&2
    echo "Move or remove it manually, then run this script again." >&2
    exit 1
fi

ln -sfn "$STORAGE_TARGET" "$STORAGE_LINK"

chmod 755 "$PUBLIC_HTML"
chmod 644 "$PUBLIC_HTML/index.php"

echo "Optimizing Laravel..."
php "$APP_ROOT/artisan" optimize

echo "Deployment complete."
echo "Public files: $PUBLIC_HTML"
echo "Storage link: $STORAGE_LINK -> $STORAGE_TARGET"
