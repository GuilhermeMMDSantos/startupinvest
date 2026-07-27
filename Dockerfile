FROM node:18-alpine AS assets

WORKDIR /app
COPY package.json ./
RUN npm install
COPY webpack.mix.js ./
COPY resources/js resources/js
COPY resources/sass resources/sass
COPY public public
RUN npm run production

FROM php:7.4-fpm-alpine AS app

RUN apk add --no-cache \
        libpng-dev \
        libzip-dev \
        libxml2-dev \
        oniguruma-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        icu-dev \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY . .
COPY --from=assets /app/public/js public/js
COPY --from=assets /app/public/css public/css
COPY --from=assets /app/public/mix-manifest.json public/mix-manifest.json

RUN composer dump-autoload --optimize \
    && chown -R www-data:www-data storage bootstrap/cache



EXPOSE 9000
CMD ["php-fpm"]
