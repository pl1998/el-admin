#!/usr/bin/env bash
cp -f ./tests/.env.testing ./laravel-tests/.env
cd ./laravel-tests
git clone https://github.com/pl1998/el-admin.git
composer config repositories.latent path el-admin
composer require latent/el-admin:dev-master
php artisan vendor:publish --provider="Latent\ElAdmin\ElAdminServiceProvider"  --force
php artisan el-admin:install
cd el-admin
composer install
