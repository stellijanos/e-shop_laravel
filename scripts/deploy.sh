#!/bin/bash

APP_DIR="/home/stellijanos/domains/e-shop.stellijanos.com/public_html"

cd $APP_DIR || exit

php artisan down

git pull

composer install --no-dev

npm install

npm run build

php artisan migrate --force

php artisan config:cache

php artisan up
