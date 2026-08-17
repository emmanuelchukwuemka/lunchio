#!/usr/bin/env sh
set -e

echo "DEBUG DB_CONNECTION=[$DB_CONNECTION] DB_HOST=[$DB_HOST] DB_PORT=[$DB_PORT] DB_DATABASE=[$DB_DATABASE] DB_USERNAME=[$DB_USERNAME] DB_SSLMODE=[$DB_SSLMODE] DB_PASSWORD_LEN=${#DB_PASSWORD} DB_PASSWORD_FIRST=[$(printf '%s' "$DB_PASSWORD" | cut -c1)] DB_PASSWORD_LAST=[$(printf '%s' "$DB_PASSWORD" | rev | cut -c1)]"

php artisan config:clear
php artisan migrate --force
php artisan storage:link || true
php artisan config:cache
php artisan view:cache

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
