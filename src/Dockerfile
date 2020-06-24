FROM php:7.1-fpm-alpine

RUN apk add --no-cache --virtual .build-deps \
       $PHPIZE_DEPS \
       curl-dev \
       imagemagick-dev \
       libtool \
   && apk add --no-cache \
       curl \
       git \
       imagemagick \
       mysql-client \
       bash \
       dpkg-dev \
       nodejs \
       npm \
   && pecl install imagick \
   && docker-php-ext-enable imagick \
   && docker-php-ext-install \
       bcmath \
       curl \
       pdo \
       pdo_mysql \
   && curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer \
   && apk del -f .build-deps

## Copy existing application directory contents
COPY . /var/www/html
WORKDIR /var/www/html
RUN composer install --ignore-platform-reqs --no-scripts
RUN chmod -R 777 /var/www/html/storage
RUN chmod -R 777 /var/www/html/bootstrap/cache
