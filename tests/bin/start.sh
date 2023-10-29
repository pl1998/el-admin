#!/usr/bin/env bash

cd ./laravel-tests
export DISPLAY=:99.0
sudo chmod -R 777  storage
sudo chmod -R 777  bootstrap/cache
php artisan serve --port=8000 > /dev/null 2>&1 &
cd storage/logs
cat laravel.log

