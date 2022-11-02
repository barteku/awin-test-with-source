FROM php:7.4-apache

# installing pakages
RUN apt-get update && apt-get install git -y autoconf libonig-dev automake make gcc g++ libtool zlib1g-dev openssh-client pkg-config libzip-dev zip libicu-dev libxml2-dev libcurl4-openssl-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl opcache pdo pdo_mysql xml mbstring curl dom \
    && docker-php-ext-enable opcache \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip


RUN pecl install apcu \
    && docker-php-ext-enable apcu

RUN a2enmod rewrite

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --filename=composer --install-dir=/usr/local/bin

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1


# setting up project
WORKDIR /var/www/


# copy sources
COPY . .
RUN rm -Rf .docker/

RUN set -eux; \
    if [ -f composer.json ]; then \
		composer install --no-autoloader --no-scripts --no-progress; \
    fi

RUN set -eux; \
	mkdir -p var/cache var/logs; \
    if [ -f composer.json ]; then \
		composer dump-autoload --apcu --no-interaction  --no-dev; \
		sync; \
    fi


# Configure the external interface for the container
EXPOSE 80
