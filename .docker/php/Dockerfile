FROM php:8.3-fpm

ENV PHP_POST_MAX_SIZE=10M
ENV PHP_VERSION=8.3

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git

RUN docker-php-ext-install zip pdo pdo_mysql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# UID=1000 y GID=1000 → idéntico en todos los ordenadores
RUN groupadd -g 1000 developer \
    && useradd -u 1000 -g developer -m developer

RUN sed -i "s/www-data/developer/g" /usr/local/etc/php-fpm.d/www.conf

USER developer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/php
