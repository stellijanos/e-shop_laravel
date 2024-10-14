#!/bin/bash

#!/bin/bash




# Variables
APP_DIR="/home/stellijanos/domains/e-shop.stellijanos.com/public_html"
REPO_URL="git@github.com:stellijanos/e-shop_laravel.git" 
BRANCH="main"
DB_NAME="e_shop_laravel"
DB_USER="stellijanos"
DB_PASSWORD="your_db_password"
DOMAIN="e-shop.stellijano.com www.e-shop.stellijanos.com" 

# Update and install necessary packages
sudo apt update
sudo apt install -y git curl unzip nginx php-fpm php-mysql php-xml php-mbstring php-zip php-bcmath php-tokenizer composer

# Clone the repository
if [ ! -d "$APP_DIR" ]; then
    git clone -b $BRANCH $REPO_URL $APP_DIR
else
    echo "App directory already exists."
fi

# Set directory permissions
cd $APP_DIR
sudo chown -R www-data:www-data $APP_DIR
sudo chmod -R 755 $APP_DIR
sudo chmod -R 775 $APP_DIR/storage
sudo chmod -R 775 $APP_DIR/bootstrap/cache

# Install Laravel dependencies
composer install --optimize-autoloader --no-dev

# Create .env file
cp .env.example .env

# Set environment variables
sed -i "s/DB_DATABASE=.*/DB_DATABASE=${DB_NAME}/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=${DB_USER}/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=${DB_PASSWORD}/" .env

# Generate Laravel application key
php artisan key:generate


# Enable Nginx configuration and restart services
# sudo ln -s /etc/nginx/sites-available/your-laravel-app /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx

# Run migrations and seed database (optional)
php artisan migrate # --seed

# Optimize the Laravel application
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Initial setup completed successfully!"
