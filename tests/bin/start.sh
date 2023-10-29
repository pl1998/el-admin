#!/usr/bin/env bash

cd ./laravel-tests
export DISPLAY=:99.0
php artisan serve --port=8000  > /dev/null 2>&1 &
curl 127.0.0.1:8000
