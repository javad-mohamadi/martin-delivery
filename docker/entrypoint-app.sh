#!/bin/sh

############################################################
# Author: Javad Mohamadi <javadmohamadi.dev@gmail.com>    #
############################################################

echo "=========================Entrypoint is running========================="

# Wait for MySQL container to start
echo "Waiting for MySQL container to start..."
sleep 15  # Add a delay of 10 seconds (adjust as needed)

echo "==> Repair environment variables"
cp /var/www/.env.example /var/www/.env

echo "composer install"
composer install

echo "composer dum autoload"
composer dump-autoload

echo "==> Start to clear cached data"
php /var/www/artisan config:clear
php /var/www/artisan cache:clear
php /var/www/artisan route:clear
php /var/www/artisan view:clear
php /var/www/artisan clear-compiled
echo "==> Cached cleared successfully"

echo "==> Start to run migrations"
php /var/www/artisan migrate
echo "==> Complete migrations"

echo "==> Start to run seeder"
php /var/www/artisan db:seed
echo "==> Complete seeder"

echo "==> Start to run passport install"
php /var/www/artisan passport:install
echo "==> Complete passport install"

php-fpm
