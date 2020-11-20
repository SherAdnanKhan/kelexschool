FROM php:7.4-fpm-alpine
WORKDIR /meuzm-app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - \
#   && apt-get update -qq && apt-get install -y build-essential && apt install -y nodejs

COPY . /meuzm-app

RUN composer install
RUN chmod -R 0777 "/meuzm-app/storage"
RUN chmod +x "/meuzm-app/docker/docker-entrypoint-staging.sh"
RUN docker-php-ext-install pdo pdo_mysql
EXPOSE 8000

ENTRYPOINT [ "/bin/sh","/meuzm-app/docker/docker-entrypoint-staging.sh" ]
