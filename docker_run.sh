#!/bin/bash
set -e

cd /var/www
env >> /var/www/.env
php-fpm8.1 -D
php artisan clear-compiled
php artisan config:clear
nginx -g "daemon off;"
