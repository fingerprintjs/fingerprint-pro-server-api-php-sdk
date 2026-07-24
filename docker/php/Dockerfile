FROM php:8.4-cli-alpine

# Install dependencies and Xdebug
RUN apk add --no-cache \
    icu-dev \
    linux-headers \
    autoconf \
    g++ \
    make \
    && docker-php-ext-install intl \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del autoconf g++ make

# Configure Xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini