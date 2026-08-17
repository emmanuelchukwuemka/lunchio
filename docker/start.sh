#!/usr/bin/env sh
set -e

# Env vars pasted into Render's dashboard can pick up a trailing newline
# (seen in practice with DB_PASSWORD) which breaks auth silently. Strip it.
export DB_HOST=$(printf '%s' "$DB_HOST" | tr -d '\n\r')
export DB_PORT=$(printf '%s' "$DB_PORT" | tr -d '\n\r')
export DB_DATABASE=$(printf '%s' "$DB_DATABASE" | tr -d '\n\r')
export DB_USERNAME=$(printf '%s' "$DB_USERNAME" | tr -d '\n\r')
export DB_PASSWORD=$(printf '%s' "$DB_PASSWORD" | tr -d '\n\r')

php artisan config:clear
php artisan migrate --force
php artisan storage:link || true
php artisan config:cache
php artisan view:cache

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
