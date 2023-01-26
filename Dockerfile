FROM php:7.4.33-apache as COMPOSE-BUILDER

ARG COMPOSER_VERSION=1.10.26
ENV COMPOSER_MEMORY_LIMIT=-1

WORKDIR /app

COPY ./ ./

RUN apt-get update \
    && apt-get install -yqq --no-install-recommends \
    libzip-dev

RUN docker-php-ext-install zip

COPY ./ ./

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION && \
    composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader

FROM php:7.4.33-apache

WORKDIR /var/www/html/

RUN apt-get update && \ 
    apt-get install -yqq --no-install-recommends \
    supervisor \
    nano \
    git \
    zlib1g-dev \
    libtool-bin \
    libpq-dev \
    unzip \
    libpng-dev \
    libzip-dev \
    libssl-dev \
    libbz2-dev \
    libxml2-dev \
    libjpeg-dev && \
    apt-get clean autoclean && \
    apt-get autoremove --yes && \
    rm -rf /var/lib/{apt,dpkg,cache,log}/ && \
    rm -rf /tmp/*

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install zip pdo_pgsql pgsql gd

RUN a2dissite * && a2enmod rewrite

COPY ./build/laravel-virtualhost.conf /etc/apache2/sites-available/

RUN a2ensite laravel-virtualhost.conf

COPY ./build/customphp.ini /usr/local/etc/php/conf.d/
COPY ./build/supervisord.conf /etc/supervisor/

COPY ./ /var/www/html/

COPY --from=COMPOSE-BUILDER /app/vendor/ /var/www/html/vendor

RUN chmod 777 -R storage/ bootstrap/cache/ && chown -R www-data:www-data /var/www/ && \
    find /var/www/ -type d -exec chmod -R 755 {} \; && find /var/www/ -type f -exec chmod -R 644 {} \; && \
	mkdir -p /var/www/html/storage/framework/cache/data && chown -R $USER:www-data /var/www/html/storage/framework/cache/data && \
	chmod -R 777 /var/www/html/storage/framework/cache/data

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
