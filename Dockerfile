FROM php:8.3-fpm

# 1. Dépendances système
RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git curl unzip && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql

# 2. Installer Node.js 22 (AVANT de copier le code pour isoler les couches)
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - && \
    apt-get install -y nodejs

# 3. Installer Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www

# 4. Copier les fichiers (Assure-toi d'avoir le .dockerignore créé plus bas)
COPY . .

# 5. Nettoyer et Installer
RUN rm -rf node_modules vendor && \
    composer install --no-interaction --prefer-dist --optimize-autoloader && \
    npm install && \
    npm run build

RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

EXPOSE 9000
CMD ["php-fpm"]