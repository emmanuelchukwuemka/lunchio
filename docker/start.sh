#!/usr/bin/env sh
set -e

echo "DEBUG DB_PASSWORD_LEN=${#DB_PASSWORD} DB_PASSWORD_CHARS=[$(printf '%s' "$DB_PASSWORD" | sed 's/./[&]/g')]"
echo "DEBUG DB_PASSWORD_HEX=[$(printf '%s' "$DB_PASSWORD" | od -An -tx1 | tr -d '\n ')]"

php artisan config:clear
php artisan migrate --force
php artisan storage:link || true
php artisan config:cache
php artisan view:cache

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
