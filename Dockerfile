FROM php:8.1-fpm-alpine3.14

ARG USER
ARG UID

WORKDIR /var/www

RUN rm -rf /var/www/html && \
    apk update && apk add --no-cache \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    && apk add --no-cache --virtual .build-deps \
    autoconf \
    g++ \
    make \
    && docker-php-ext-install mbstring exif pcntl bcmath gd pdo pdo_mysql dom\
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && apk add --no-cache libxml2-dev

RUN addgroup -g $UID $USER && \
    adduser -u $UID -G $USER -D $USER

COPY --from=composer:2.2.12 /usr/bin/composer /usr/bin/composer

COPY --chown=$USER:$USER . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R $USER:$USER /var/www

COPY ./docker/config/php.ini /usr/local/etc/php/php.ini

EXPOSE 9000
USER $USER
CMD ["php-fpm"]