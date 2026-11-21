FROM php:7.4-apache AS base

RUN sed -i 's|http://deb.debian.org/debian-security|https://archive.debian.org/debian-security|' /etc/apt/sources.list \
    && apt-get -o Acquire::Check-Valid-Until=false update \
    && apt-get install -y --no-install-recommends libcurl4-openssl-dev libonig-dev libpq-dev unzip \
    && docker-php-ext-install -j"$(nproc)" curl mbstring pdo_pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2.2 /usr/bin/composer /usr/local/bin/composer
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
EXPOSE 80

FROM base AS development

COPY . .

RUN mkdir -p \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/testing \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && composer install --prefer-dist --no-interaction

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
EXPOSE 8000

FROM base AS production

COPY . .

RUN mkdir -p \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/testing \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader \
    && php artisan storage:link \
    && chown -R www-data:www-data storage bootstrap/cache \
    && rm /usr/local/bin/composer

CMD ["apache2-foreground"]
