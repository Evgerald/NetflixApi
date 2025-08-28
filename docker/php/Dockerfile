FROM php:8.4-fpm-alpine

WORKDIR /var/www/netflixAPI

RUN apk add --no-cache zip unzip git bash autoconf g++ make linux-headers \
    && docker-php-ext-install pdo pdo_mysql bcmath opcache \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del autoconf g++ make

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini