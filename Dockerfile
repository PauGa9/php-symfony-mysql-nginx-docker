FROM php:7.4-fpm-alpine

RUN docker-php-ext-install pdo_mysql

RUN apk update && apk add php7-dev g++ make

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN echo 'xdebug.remote_enable = ${XDEBUG_ENABLED}' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.remote_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY ./start-container.sh /app/start-container.sh