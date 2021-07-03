FROM php:8.0-fpm-alpine

RUN apk add --no-cache  $PHPIZE_DEPS icu-dev libxml2-dev libzip-dev curl-dev gettext-dev libtool file && \
    docker-php-ext-install pdo_mysql opcache xml zip curl gettext intl

RUN mkdir /app
WORKDIR /app
VOLUME /app
