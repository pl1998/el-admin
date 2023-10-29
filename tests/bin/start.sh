#!/usr/bin/env bash

cd ./laravel-tests
php artisan serve --port=8000  > /dev/null 2>&1 &
lsof -i:8000
#sudo chmod -R 777  ./storage
#sudo chmod -R 777  ./bootstrap/cache


