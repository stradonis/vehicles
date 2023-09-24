FROM php:8.2-fpm

RUN apt update && \
    apt-get install -y --no-install-recommends libssl-dev zlib1g-dev curl git unzip libxml2-dev libpq-dev libzip-dev && \
    docker-php-ext-install intl opcache && \
    pecl install apcu && \
    docker-php-ext-install -j$(nproc) zip opcache intl bcmath && \
    docker-php-ext-enable apcu sodium

#install  pgsql
RUN apt-get install -y libxml2-dev libpq-dev && \
        docker-php-ext-install pdo pgsql pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer && chmod +x /usr/bin/composer

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
  && apt install symfony-cli

COPY php.ini /usr/local/etc/php

WORKDIR /var/www

EXPOSE 9000
