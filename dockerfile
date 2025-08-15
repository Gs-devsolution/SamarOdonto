# Dockerfile (PHP 7.4 + Apache)
FROM php:7.3-apache

# libs e extensões necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev zip libonig-dev libpng-dev \
 && docker-php-ext-install pdo_mysql mbstring zip gd \
 && a2enmod rewrite

# DocumentRoot -> public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# código da app
WORKDIR /var/www/html
COPY . /var/www/html

# Composer (copiado da imagem oficial do Composer 2)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar deps sem dev (NÃO roda scripts durante build)
RUN COMPOSER_NO_SCRIPTS=1 composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction

# Permissões Laravel
RUN chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache

# Sobe o Apache
CMD ["apache2-foreground"]
