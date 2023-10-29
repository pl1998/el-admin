#!/usr/bin/env bash

cd ./laravel-tests
sudo chmod -R 777  ./storage
sudo chmod -R 777  ./bootstrap/cache
php artisan serve --port=8000  > /dev/null 2>&1 &
curl 127.0.0.1:8000
