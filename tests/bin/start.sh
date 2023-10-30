#!/usr/bin/env bash

cd ./laravel-tests
export DISPLAY=:99.0
sudo chmod -R 0755  storage
sudo chmod -R 0755  bootstrap/cache
sudo ls -la
sudo php artisan serve --port=8300 > /dev/null 2>&1 &
sudo ps -ef | grep php
