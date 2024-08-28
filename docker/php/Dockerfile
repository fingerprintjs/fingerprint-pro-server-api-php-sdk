FROM php:8.2-cli

# Install dependencies and Xdebug
RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install intl \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Configure Xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini