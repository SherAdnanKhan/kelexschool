FROM php:7.2-fpm-alpine

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /meuzm-app
COPY . /meuzm-app

RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000