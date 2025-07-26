FROM nginx:alpine AS nginx

ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY ./public /app/public

COPY build/nginx/default.conf /etc/nginx/conf.d/default.conf

RUN rm /var/log/nginx/access.log && rm /var/log/nginx/error.log

WORKDIR /app

FROM php:8.4-fpm-alpine3.22 AS base

ENV TZ=UTC
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN rm -rf /var/cache/apk/*

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

COPY build/php/php.ini $PHP_INI_DIR/conf.d/php.ini

RUN install-php-extensions \
    bcmath \
    pdo \
    pdo_pgsql \
    && rm -rf /tmp/*

FROM base AS vendor

WORKDIR /build

COPY composer* ./
COPY symfony.* ./

RUN set -aux; \
    composer install --no-cache --prefer-dist --no-autoloader --no-scripts --no-progres --no-dev --no-interaction

FROM base AS runtime-production

COPY build/php/php-opcache.ini $PHP_INI_DIR/php-opcache.ini

COPY ./ /app
COPY --from=vendor /build/vendor /app/vendor
RUN rm -rf /app/build

WORKDIR /app

RUN set -eux; \
    composer dump-autoload --optimize; \
    compsoer run-script post-install-cmd

RUN chown -R www-data:www-data /app/var
RUN chown -R www-data:www-data /app/vendor

USER www-data

FROM base AS runtime-development
ARG USER_ID

COPY build/php/php-dev.ini $PHP_INI_DIR/php-dev.ini

RUN set -eux; \
    install-php-extensions \
        xdebug-3.4.1; \
    rm -rf /tmp/*

RUN adduser -D -H -u ${USER_ID} -G www-data local
USER local

WORKDIR /app
