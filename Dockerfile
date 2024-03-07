FROM composer:2.7.1 AS composer

FROM php:8.3-fpm-alpine3.17 AS base

RUN apk add --no-cache \
    autoconf \
    bash \
    git \
    libzip-dev \
    icu-dev \
    rabbitmq-c-dev

RUN apk add --no-cache --virtual .phpize-deps ${PHPIZE_DEPS}

RUN pecl install apcu amqp && docker-php-ext-enable apcu amqp

RUN docker-php-ext-configure zip && docker-php-ext-install -j"$(nproc)" \
    zip \
    intl \
    opcache \
    pdo \
    pdo_mysql

RUN apk del --no-network .phpize-deps

COPY config/php.ini /usr/local/etc/php/php.ini
COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV PATH="$PATH:/app/bin"

WORKDIR /app

FROM base AS dev

RUN apk add --no-cache bash \
  && curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash \
  && apk add --no-cache symfony-cli

RUN apk add --no-cache gcc g++ make autoconf linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del --no-network gcc g++ make autoconf linux-headers

COPY config/dev/* /usr/local/etc/php/conf.d/
