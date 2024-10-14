#!/bin/bash


# Variables
APP_DIR="/home/stellijanos/domains/e-shop.stellijanos.com/public_html"
BRANCH="main"
DOMAIN="e-shop.stellijano.com www.e-shop.stellijanos.com" 

# Pull the latest code from the repository
cd $APP_DIR
git fetch origin $BRANCH
git reset --hard origin/$BRANCH

# Install/update Composer dependencies
composer install --optimize-autoloader --no-dev


# Clear and cache Laravel configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set file permissions
sudo chown -R www-data:www-data $APP_DIR
sudo chmod -R 775 $APP_DIR/storage
sudo chmod -R 775 $APP_DIR/bootstrap/cache

# Restart PHP-FPM to apply changes
sudo systemctl restart php-fpm

# Run database migrations (optional)
php artisan migrate --force

echo "Deployment completed successfully!"
