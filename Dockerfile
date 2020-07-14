FROM php:7.2-fpm-alpine
WORKDIR /meuzm-app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - \
#   && apt-get update -qq && apt-get install -y build-essential && apt install -y nodejs

COPY . /meuzm-app

RUN composer install
RUN chmod -R 0777 "/meuzm-app/storage"
EXPOSE 8000

ENTRYPOINT [“/meuzm-app/app/Console/docker-entrypoint-staging.sh”]
