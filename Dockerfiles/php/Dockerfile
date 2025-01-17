FROM php:8.2.27-fpm-alpine

WORKDIR /var/www/laravel

ENV PHPUSER=laravel
ENV PHPGROUP=laravel

RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}

RUN sed -i "s/user = www-data/user = ${PHPUSER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${PHPGROUP}/g" /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /var/www/laravel/public

RUN docker-php-ext-install pdo pdo_mysql

RUN apk add --no-cache ffmpeg ffmpeg-libs

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]