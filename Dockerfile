# Use an official PHP runtime
FROM php:8.2.0-apache

RUN apt-get -y update && apt-get -y upgrade

RUN a2enmod rewrite
RUN a2enmod proxy
RUN a2enmod proxy_http

RUN pecl install xdebug-3.3.2 && docker-php-ext-enable xdebug
RUN apt-get install -y libxml2-dev
RUN docker-php-ext-install soap

RUN pecl install redis && docker-php-ext-enable redis

RUN apt update \
        && apt -y upgrade \
        && apt install -y \
            libfreetype6-dev \
            libjpeg62-turbo-dev \
            libpng-dev \
            libtidy-dev \
            libzip-dev \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql exif tidy zip

RUN apt-get -y update \
        && apt-get install -y libicu-dev \
        && docker-php-ext-configure intl \
        && docker-php-ext-install intl

RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    && docker-php-ext-install curl

RUN apt-get update

#Composer'ı yüklemek için gerekli bağımlılıkları yükle
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Composer'ı indir ve kur
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update

RUN apt-get install vim -y


WORKDIR /var/www/html/example

COPY ../www .

