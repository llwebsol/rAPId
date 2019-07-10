# Install Composter dependencies
FROM composer:1.8.6 as composer
WORKDIR /packages
COPY ./composer.* ./
RUN composer install


FROM php:7.2-apache

    # Enable Mod Rewrite
RUN a2enmod rewrite \
    # Include pdo db extensions
    && docker-php-ext-install \
        pdo \
        # pdo_pgsql \
        pdo_mysql \
    # Change port from 80 to 5000 for CI/CD pipeline compatability
    && sed -i 's/Listen 80/Listen 5000/' /etc/apache2/ports.conf

WORKDIR /var/www/html

COPY . .
COPY --from=composer /packages/vendor ./vendor

EXPOSE 5000