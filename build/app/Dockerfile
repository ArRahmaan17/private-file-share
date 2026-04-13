# Stage 1: Composer build
FROM composer:latest as composer_stage
WORKDIR /app
# Copy only composer files to leverage Docker cache
COPY applications/composer.json applications/composer.lock ./
# Install dependencies with platform requirements ignored to avoid missing extension errors in this stage
RUN composer install \
    --no-dev \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# Stage 2: Runtime
FROM php:8.4-fpm-alpine as app

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    libzip-dev \
    bash \
    icu-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        xml

# Copy application code
COPY applications /var/www/html

# Copy vendor from composer stage
COPY --from=composer_stage /app/vendor /var/www/html/vendor

# Reuse Composer from the builder image to avoid a second network fetch
COPY --from=composer_stage /usr/bin/composer /usr/local/bin/composer

# Build a production autoloader and package manifest inside the image
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/app/uploads bootstrap/cache \
    && composer dump-autoload --optimize --no-dev --no-scripts \
    && rm -f bootstrap/cache/*.php \
    && php artisan package:discover --ansi

# Create necessary directories and set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Copy custom php.ini
COPY build/app/php.ini /usr/local/etc/php/conf.d/custom-php.ini
COPY build/app/entrypoint.sh /usr/local/bin/entrypoint

RUN chmod +x /usr/local/bin/entrypoint

# Switch to non-root user
USER www-data

ENTRYPOINT ["entrypoint"]
EXPOSE 9000
CMD ["php-fpm"]
