FROM php:8.2-fpm-alpine AS base

RUN apk update --no-cache

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN set -eux; \
    install-php-extensions pcov redis pdo pdo_pgsql \
    && rm -rf /tmp/*

WORKDIR /app

FROM base AS development

RUN set -eux; \
    install-php-extensions xdebug \
    && rm -rf /tmp/*

COPY build/php/dev.ini $PHP_INI_DIR/conf.d/php-ini-overrides.ini
