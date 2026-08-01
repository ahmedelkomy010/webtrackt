@echo off
setlocal

echo ==^> Installing PHP dependencies...
call composer install --no-dev --optimize-autoloader

echo ==^> Building frontend assets...
call npm ci
call npm run build

echo ==^> Laravel setup...
php artisan migrate --force
php artisan storage:link 2>nul
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan cache:clear

echo Done. Verify APP_URL in .env matches your domain.
