FROM php:fpm

RUN apt-get update \
    && apt-get install -y curl zip unzip \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN docker-php-ext-install pdo pdo_mysql opcache

RUN pecl install xdebug && docker-php-ext-enable xdebug && docker-php-ext-enable opcache

COPY ./php.ini "${PHP_INI_DIR}/conf.d"

WORKDIR /app
