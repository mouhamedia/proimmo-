FROM php:8.3-fpm

# 1. Dépendances système
RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git curl unzip && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql

# 2. Installer Node.js 22
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - && \
    apt-get install -y nodejs

# 3. Installer Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# 4. Config PHP pour Laravel (cookies + session)
RUN echo "output_buffering = 4096" > /usr/local/etc/php/conf.d/laravel.ini \
 && echo "session.cookie_samesite = Lax" >> /usr/local/etc/php/conf.d/laravel.ini

WORKDIR /var/www

# 5. Copier les fichiers
COPY . .

# 6. Nettoyer et Installer
RUN rm -rf node_modules vendor && \
    composer install --no-interaction --prefer-dist --optimize-autoloader && \
    npm install && \
    npm run build

RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

EXPOSE 9000
CMD ["php-fpm"]