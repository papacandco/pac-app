FROM ubuntu:22.04
ARG DEBIAN_FRONTEND=noninteractive

COPY ./ /app

WORKDIR /app

# Sys deps
RUN apt-get update && apt upgrade -y
RUN apt-get install -y git software-properties-common ca-certificates \
    libncursesw5-dev zip unzip libglib2.0-dev \
    libgeoip-dev libtokyocabinet-dev curl

# NodeJs Setup
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs

# PHP Setup
RUN add-apt-repository ppa:ondrej/php -y
RUN apt-get install -y \
    php8.1-cli php8.1-mysql \
    php8.1-mbstring php8.1-xml php8.1-iconv \
    php8.1-gd php8.1-fpm php8.1-dom \
    php8.1-zip php8.1-bcmath php8.1-sqlite3 \
    php8.1-pgsql php8.1-curl php8.1-intl

## PHP Composer setup
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --filename=composer --install-dir=/usr/local/bin
RUN php -r "unlink('composer-setup.php');"
RUN rm -rf vendor
RUN composer update

## NPN Setup
RUN npm install --force --legacy-peer-deps 2> /dev/null
RUN cp system/fixtures/Vue.js node_modules/laravel-mix/src/components/Vue.js

EXPOSE 8000
