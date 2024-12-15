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
    php8.3-cli php8.3-mysql \
    php8.3-mbstring php8.3-xml php8.3-iconv \
    php8.3-gd php8.3-fpm php8.3-dom \
    php8.3-zip php8.3-bcmath php8.3-sqlite3 \
    php8.3-pgsql php8.3-curl php8.3-intl

## PHP Composer setup
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --filename=composer --install-dir=/usr/local/bin
RUN php -r "unlink('composer-setup.php');"
RUN rm -rf vendor
RUN composer update

EXPOSE 8000

CMD [ "php", "bow", "run:server", "--port=8000" ]
