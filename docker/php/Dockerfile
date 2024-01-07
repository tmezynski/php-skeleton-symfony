FROM php:8.2-fpm-alpine

RUN apk update

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apk --no-cache add autoconf g++ make linux-headers\
    && pecl install pcov && docker-php-ext-enable pcov\
    && pecl install xdebug && docker-php-ext-enable xdebug\
    && apk del autoconf g++ make linux-headers
