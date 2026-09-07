#!/bin/bash

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
until nc -z -v -w30 mysql 3306
do
  echo "Waiting for database connection..."
  sleep 2
done

echo "MySQL is ready!"

# Go to working directory
cd /var/www

# Install composer dependencies if vendor doesn't exist
if [ ! -d "/var/www/vendor" ]; then
    echo "Installing composer dependencies..."
    composer install --no-interaction --optimize-autoloader
fi

# Generate key if .env exists but APP_KEY is empty
if [ -f "/var/www/.env" ]; then
    if ! grep -q "APP_KEY=base64:" /var/www/.env; then
        echo "Generating application key..."
        php artisan key:generate --force
    fi
fi

# Set permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Run seeders
echo "Running seeders..."
php artisan db:seed --force

exec "$@"
