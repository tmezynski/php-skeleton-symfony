FROM php:8.3-fpm-alpine AS base

RUN set -eux
RUN apk update --no-cache

ARG USER_ID
ARG GROUP_ID

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions bcmath pcov redis pdo pdo_pgsql \
    && rm -rf /tmp/*

RUN adduser -D -u ${USER_ID} -G www-data local

WORKDIR /app

FROM base AS development

RUN install-php-extensions xdebug \
    && rm -rf /tmp/*

COPY build/php/dev.ini $PHP_INI_DIR/conf.d/php-ini-overrides.ini

USER local
