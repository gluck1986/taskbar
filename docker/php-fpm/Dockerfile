FROM php:7.4-fpm

RUN apt-get update \
    && apt-get -y --no-install-recommends install libonig-dev libzip-dev zip curl wget git

RUN docker-php-ext-configure zip \
 && docker-php-ext-install zip \
 && docker-php-ext-install json \
 && docker-php-ext-install mbstring \
 && docker-php-ext-install pdo

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


USER root

RUN usermod -u 1000 www-data

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000