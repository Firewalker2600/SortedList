FROM php:8.2-cli AS app_php

RUN apt-get update -y && apt-get install -y libmcrypt-dev git zip unzip libzip-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo zip

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony



WORKDIR /app
COPY . /app

RUN composer install

EXPOSE 8000
CMD symfony server:start

