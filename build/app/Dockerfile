# Stage 1: Composer build
FROM composer:latest as composer_stage
WORKDIR /app
COPY applications/composer.json applications/composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --ignore-platform-reqs

# Stage 2: Runtime
FROM php:8.4-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    libpng-dev \
    oniguruma-dev \
    libzip-dev \
    mariadb-client \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apk del --no-cache .build-deps || true

# Copy application code
COPY applications /var/www/html

# Create necessary directories and set initial permissions
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/app/uploads bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Copy vendor from composer stage
COPY --from=composer_stage /app/vendor /var/www/html/vendor

# Optimized autoloader
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer dump-autoload --optimize --no-dev --no-scripts \
    && rm /usr/local/bin/composer

# Copy custom php.ini
COPY build/app/php.ini /usr/local/etc/php/conf.d/custom-php.ini

# Final permission fix
RUN chmod -R 775 storage bootstrap/cache

# Switch to non-root user
USER www-data

EXPOSE 9000
CMD ["php-fpm"]
