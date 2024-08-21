FROM php:8.3-fpm-alpine AS base

RUN apk add autoconf build-base libzip-dev zip linux-headers bash \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install zip opcache

WORKDIR /var/www
COPY ./app /var/www

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "zend_extension = xdebug.so" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode = debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host = false" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && composer install --no-interaction --ignore-platform-reqs