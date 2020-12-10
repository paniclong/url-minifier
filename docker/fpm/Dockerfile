FROM php:7.4.11-fpm-alpine

RUN apk update \
    && apk add  --no-cache git bash mysql-client curl libmcrypt libmcrypt-dev openssh openssh-client icu-dev \
    libxml2-dev freetype-dev libpng-dev libjpeg-turbo-dev g++ make autoconf libzip-dev postgresql-dev pwgen \
    && docker-php-source extract \
    && pecl install xdebug redis \
    && docker-php-ext-enable xdebug redis \
    && docker-php-source delete \
    && docker-php-ext-install pgsql pdo_pgsql pdo_mysql soap intl zip \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=172.17.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && rm -rf /tmp/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/url-minifier

COPY . .

RUN chmod 777 /var/log/

RUN composer install -o --no-dev

EXPOSE 9000

CMD ["php-fpm"]
