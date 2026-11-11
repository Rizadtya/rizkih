
FROM php:8.4-fpm

WORKDIR /var/www

# Install dependencies and Nginx
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    gettext-base \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    netcat-openbsd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Application
COPY . /var/www

# Nginx configuration template
COPY docker/nginx/default.conf /etc/nginx/default.conf.template

# Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Remove default Nginx site
RUN rm -f /etc/nginx/sites-enabled/default

# Permissions
RUN chown -R www-data:www-data /var/www

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

