FROM php:8.4-cli-alpine

# Install runtime dependencies
RUN apk add --no-cache icu-libs

# Install build dependencies
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    icu-dev \
    linux-headers \
    && docker-php-ext-install intl \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del .build-deps

# Configure Xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini