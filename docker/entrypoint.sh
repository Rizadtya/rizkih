
#!/bin/bash
set -e

cd /var/www

echo "Starting Laravel application..."

# Wait for database
if [ -n "$DB_HOST" ]; then
    echo "Waiting for database: $DB_HOST"

    until nc -z -w5 "$DB_HOST" "${DB_PORT:-3306}"; do
        echo "Waiting for database connection..."
        sleep 2
    done

    echo "Database is ready!"
fi

# Install dependencies if vendor is missing
if [ ! -d "/var/www/vendor" ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Check application key
if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY is missing!"
    exit 1
fi

# Set permissions
chown -R www-data:www-data storage bootstrap/cache

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Configure Nginx
export PORT="${PORT:-8080}"

envsubst '${PORT}' < /etc/nginx/default.conf.template \
    > /etc/nginx/conf.d/default.conf

# Start PHP-FPM
echo "Starting PHP-FPM..."
php-fpm -D

# Start Nginx
echo "Starting Nginx on port $PORT..."
exec nginx -g "daemon off;"

