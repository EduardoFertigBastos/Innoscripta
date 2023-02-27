#!/bin/sh

cd /var/www/html
php artisan config:clear
php artisan jwt:secret
php artisan migrate
php artisan db:seed --class=ArticlesSeeder
php artisan serve --host=0.0.0.0 --port=8000
