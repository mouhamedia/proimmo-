#!/bin/bash
set -e

# Génère le .env depuis les variables d'environnement Docker si absent
if [ ! -f /var/www/.env ]; then
    echo "Création du fichier .env..."
    cp /var/www/.env.example /var/www/.env
fi

# Injecte les variables d'env Docker dans le .env
sed -i "s|DB_CONNECTION=.*|DB_CONNECTION=${DB_CONNECTION:-mysql}|g" /var/www/.env
sed -i "s|DB_HOST=.*|DB_HOST=${DB_HOST:-proimmo-db}|g" /var/www/.env
sed -i "s|# DB_HOST=.*|DB_HOST=${DB_HOST:-proimmo-db}|g" /var/www/.env
sed -i "s|DB_PORT=.*|DB_PORT=${DB_PORT:-3306}|g" /var/www/.env
sed -i "s|# DB_PORT=.*|DB_PORT=${DB_PORT:-3306}|g" /var/www/.env
sed -i "s|DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE:-proimmo}|g" /var/www/.env
sed -i "s|# DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE:-proimmo}|g" /var/www/.env
sed -i "s|DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME:-root}|g" /var/www/.env
sed -i "s|# DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME:-root}|g" /var/www/.env
sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD:-yes}|g" /var/www/.env
sed -i "s|# DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD:-yes}|g" /var/www/.env

sed -i "s|APP_URL=.*|APP_URL=${APP_URL:-http://localhost}|g" /var/www/.env
sed -i "s|SESSION_DRIVER=.*|SESSION_DRIVER=file|g" /var/www/.env
sed -i "s|CACHE_STORE=.*|CACHE_STORE=file|g" /var/www/.env
sed -i "s|QUEUE_CONNECTION=.*|QUEUE_CONNECTION=sync|g" /var/www/.env

# Génère la clé si nécessaire
php /var/www/artisan key:generate --no-interaction --force 2>/dev/null || true

# Fixe les permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Attends que MySQL soit prêt
echo "Attente de MySQL..."
until php -r "new PDO('mysql:host=${DB_HOST:-proimmo-db};port=${DB_PORT:-3306};dbname=${DB_DATABASE:-proimmo}', '${DB_USERNAME:-root}', '${DB_PASSWORD:-yes}');" 2>/dev/null; do
    echo "MySQL pas encore prêt, nouvelle tentative dans 2s..."
    sleep 2
done
echo "MySQL prêt."

# Migrations
php /var/www/artisan migrate --force --no-interaction

# Vide les caches
php /var/www/artisan config:clear
php /var/www/artisan route:clear
php /var/www/artisan view:clear

echo "Démarrage PHP-FPM..."
exec php-fpm
