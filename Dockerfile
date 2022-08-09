FROM php:7.1.7-apache

RUN apt-get update -yqq && \
    apt-get install supervisor nano zlib1g-dev libpq-dev libpng-dev -yqq --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install zip pdo_pgsql pgsql gd

RUN a2dissite * && a2enmod rewrite

COPY ./build/laravel-virtualhost.conf /etc/apache2/sites-available/

RUN a2ensite laravel-virtualhost.conf

COPY ./build/customphp.ini /usr/local/etc/php/conf.d/
COPY ./build/supervisord.conf /etc/supervisor/

COPY ./ /var/www/html/

RUN chmod 777 -R storage/ bootstrap/cache/ && chown -R www-data:www-data /var/www/ && \
    find /var/www/ -type d -exec chmod -R 755 {} \; && find /var/www/ -type f -exec chmod -R 644 {} \; && \
	mkdir -p /var/www/html/storage/framework/cache/data && chown -R $USER:www-data /var/www/html/storage/framework/cache/data && \
	chmod -R 777 /var/www/html/storage/framework/cache/data

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
