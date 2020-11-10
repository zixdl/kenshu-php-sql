FROM php:fpm

RUN apt-get update
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql

WORKDIR /home/sites/code