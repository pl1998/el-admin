#!/usr/bin/env bash

cd ./laravel-tests
git clone https://github.com/pl1998/el-admin.git
cd ./laravel-tests/el-admin && ls
cd ./laravel-tests
cp -f ./.env.example ./laravel-tests/.env
cp -f ./tests/.env.example ./laravel-tests/.env
composer config repositories.latent path el-admin
composer dump
composer require latent/el-admin:dev-master
cp -f ./laravel-tests/el-admin/.env.example ./laravel-tests/.env
php artisan vendor:publish --provider="Latent\ElAdmin\ElAdminServiceProvider"  --force
php artisan el-admin:install
cd ./laravel-tests/el-admin
composer install
