#!/usr/bin/env bash
set -euo pipefail

echo "==> Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

echo "==> Building frontend assets..."
npm ci
npm run build

echo "==> Laravel setup..."
php artisan migrate --force
php artisan storage:link 2>/dev/null || true
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan cache:clear

echo "Done. Verify APP_URL in .env matches your domain."
