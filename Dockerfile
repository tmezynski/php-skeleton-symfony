FROM nginx:alpine AS nginx

ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/"$TZ" /etc/localtime && echo "$TZ" > /etc/timezone

COPY ./public /app/public

COPY .docker/nginx/default.conf /etc/nginx/conf.d/default.conf

RUN rm /var/log/nginx/access.log && rm /var/log/nginx/error.log

WORKDIR /app

FROM php:8.5.2RC1-fpm-alpine3.23 AS base

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN rm -rf /var/cache/apk/*

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

COPY .docker/php/php.ini "$PHP_INI_DIR"/conf.d/php.ini

RUN install-php-extensions \
    http \
    bcmath \
    pdo \
    pdo_pgsql; \
    rm -rf /tmp/*;

FROM base AS vendor

WORKDIR /build

COPY composer.json ./
COPY composer.lock ./
COPY symfony.lock ./

RUN set -aux; \
    composer install --no-cache --prefer-dist --no-autoloader --no-scripts --no-progress --no-dev --no-interaction

FROM base AS runtime-production

COPY .docker/php/php-opcache.ini "$PHP_INI_DIR"/php-opcache.ini

COPY ./ /app
COPY --from=vendor /build/vendor /app/vendor
RUN rm -rf /app/.docker

WORKDIR /app

RUN set -eux; \
    composer dump-autoload --no-dev --classmap-authoritative --optimize; \
    composer run-script post-install-cmd; \
    chown -R www-data:www-data /app/var; \
    chown -R www-data:www-data /app/vendor;

USER www-data

FROM base AS runtime-development
ARG USER_ID

COPY .docker/php/php-dev.ini "$PHP_INI_DIR"/php-dev.ini

RUN set -eux; \
    install-php-extensions xdebug-3.5.0; \
    rm -rf /tmp/*; \
    adduser -D -H -u "$USER_ID" -G www-data local;

USER local

WORKDIR /app
