FROM php:8.3-fpm

# Variables de entorno
ENV PHP_POST_MAX_SIZE=10M
ENV PHP_VERSION=8.3

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install zip pdo pdo_mysql

# Instalar Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Crear usuario 'developer' con UID/GID fijo
RUN groupadd -g 1000 developer \
    && useradd -u 1000 -g developer -m developer

# Cambiar propietario de PHP-FPM www-data a developer
RUN sed -i "s/www-data/developer/g" /usr/local/etc/php-fpm.d/www.conf

# Establecer el usuario actual
USER developer

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/php

# Crear carpetas compartidas y dar permisos correctos
RUN mkdir -p /var/www/php/src/uploads /var/www/php/src/public/data \
    && chown -R developer:developer /var/www/php/src/uploads /var/www/php/src/public/data \
    && chmod -R 775 /var/www/php/src/uploads /var/www/php/src/public/data
