FROM php:7.4-alpine3.15

RUN apk add --no-cache \
    git \
    zip \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    icu-dev \
    oniguruma-dev \
    shadow \
    bash

RUN apk add --no-cache php7 php7-fpm php7-cli php7-mbstring php7-tokenizer php7-json php7-openssl php7-pdo php7-pdo_mysql

RUN docker-php-ext-install zip pdo pdo_mysql mbstring intl gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY app /var/www/localhost/htdocs/

WORKDIR /var/www/localhost/htdocs

RUN rm -f composer.lock && \
    rm -rf bootstrap/cache/*

RUN rm -f storage/logs/*

RUN composer install --no-dev --optimize-autoloader

RUN apk add --no-cache apache2 apache2-utils php7-apache2 && \
    sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/httpd.conf && \
    echo "LoadModule rewrite_module modules/mod_rewrite.so" >> /etc/apache2/httpd.conf

RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/httpd.conf && \
    echo "ServerName localhost" >> /etc/apache2/httpd.conf

RUN chown -R apache:apache /var/www/localhost/htdocs && \
    chmod -R 777 /var/www/localhost/htdocs

RUN rm -rf /var/www/localhost/htdocs/index.html

# Expose port 80 for Apache
EXPOSE 80

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Start services
CMD ["httpd", "-D", "FOREGROUND"]
