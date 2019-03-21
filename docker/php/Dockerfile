# our base image
FROM php:7.0-fpm

RUN mkdir -p /var/www/dev
WORKDIR /var/www/dev

RUN apt-get update && apt-get install -y \
curl tar git nano \
libfreetype6-dev \
libjpeg62-turbo-dev \
libxslt-dev \
libmcrypt-dev \
libxml2-dev \
&& docker-php-ext-install -j$(nproc) iconv mcrypt mbstring mysqli pdo_mysql zip \
&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
&& docker-php-ext-install -j$(nproc) gd
RUN pecl install xdebug-2.6.0 && docker-php-ext-enable xdebug

RUN curl -sS -o /tmp/icu.tar.gz -L http://download.icu-project.org/files/icu4c/55.1/icu4c-55_1-src.tgz \
    && tar -zxf /tmp/icu.tar.gz -C /tmp \
    && cd /tmp/icu/source \
    && ./configure --prefix=/usr/local \
    && make \
    && make install

RUN docker-php-ext-configure intl --with-icu-dir=/usr/local && \
    docker-php-ext-install intl

RUN curl --silent --fail --location --retry 3 --output /tmp/installer.php --url https://getcomposer.org/installer \
    && php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer \
    && composer --ansi --version --no-interaction \
    && rm -f /tmp/installer.php
