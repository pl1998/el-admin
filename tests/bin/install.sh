#!/usr/bin/env bash

cd ./laravel-tests
php artisan vendor:publish --provider="Latent\ElAdmin\ElAdminServiceProvider"  --force
php artisan el-admin:install
