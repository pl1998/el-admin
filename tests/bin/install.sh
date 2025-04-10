#!/usr/bin/env bash
for arg in "$@"; do
  if [[ $arg == --version=* ]]; then
    version=${arg#*=}
    echo "版本号: $version"
    # 在这里可以使用$version变量
  fi
done

cp -f ./tests/.env.testing ./laravel-tests/.env
cd ./laravel-tests
git clone https://github.com/pl1998/el-admin.git
composer config repositories.latent path el-admin
composer require latent/el-admin:"$version"
php artisan vendor:publish --provider="Latent\ElAdmin\ElAdminServiceProvider"  --force
php artisan el-admin:install
cd el-admin
composer install
