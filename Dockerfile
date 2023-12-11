FROM php:8.2-apache

RUN apt-get update && apt-get install -y libpq-dev wget zip && docker-php-ext-install pdo pdo_pgsql
RUN a2enmod rewrite
RUN wget https://getcomposer.org/download/2.6.6/composer.phar \
    && chmod +x ./composer.phar \
    && mv ./composer.phar /usr/bin/composer