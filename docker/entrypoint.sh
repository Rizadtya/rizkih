#!/bin/bash

DB_HOST_WAIT="${DB_HOST:-mysql}"
DB_PORT_WAIT="${DB_PORT:-3306}"

echo "Waiting for MySQL at ${DB_HOST_WAIT}:${DB_PORT_WAIT}..."
until nc -z -v -w30 "$DB_HOST_WAIT" "$DB_PORT_WAIT"
do
  echo "Waiting for database connection..."
  sleep 2
done

echo "MySQL is ready!"

cd /var/www

if [ ! -d "/var/www/vendor" ]; then
    echo "Installing composer dependencies..."
    composer install --no-interaction --optimize-autoloader
fi

if [ -f "/var/www/.env" ]; then
    if ! grep -q "APP_KEY=base64:" /var/www/.env; then
        echo "Generating application key..."
        php artisan key:generate --force
    fi
fi

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

echo "Running migrations..."
php artisan migrate --force

# Seeder hanya jalan jika RUN_SEEDER=true (di lokal compose, set manual bila perlu)
if [ "$RUN_SEEDER" = "true" ]; then
    echo "Running seeders..."
    php artisan db:seed --force
fi

# Mode Railway: jika PORT diisi, jalankan php-fpm + nginx dalam satu container
if [ -n "$PORT" ]; then
    echo "Starting nginx on port $PORT..."
    sed -i "s/PORT_PLACEHOLDER/${PORT}/" /etc/nginx/conf.d/default.conf
    php-fpm -D
    exec nginx -g 'daemon off;'
fi

exec "$@"
