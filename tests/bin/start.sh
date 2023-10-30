#!/usr/bin/env bash

cd ./laravel-tests
cat .env
export DISPLAY=:99.0
sudo php artisan serve --port=8300 > /dev/null 2>&1 &
curl --location --request POST 'http://127.0.0.1:8300/api/v1/el_admin/login'  --form 'email="admin@gmail.com"' --form 'password="123456"'
