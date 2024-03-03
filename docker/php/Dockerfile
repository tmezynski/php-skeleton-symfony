FROM php:8.2-fpm-alpine

RUN apk update

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apk --no-cache add autoconf g++ make linux-headers \
    && pecl install pcov \
    && docker-php-ext-enable pcov \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del autoconf g++ make linux-headers \
    && rm -rf /tmp/pear

RUN apk --no-cache add libpq-dev  \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /tmp/pear
