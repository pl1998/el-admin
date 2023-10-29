#!/usr/bin/env bash

cd ./laravel-tests
sudo chmod -R 777 storage
chmod -R 777 storage bootstrap/cache
php artisan serve --port=8000 --host=0.0.0.0 > /dev/null 2>&1 &
