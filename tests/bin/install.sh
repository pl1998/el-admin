#!/usr/bin/env bash

# 解析参数
# 解析参数
while [[ $# -gt 0 ]]; do
  case "$1" in
    --version=*)
      VERSION="${1#*=}"
      ;;
    --module=*)
      MODULE="${1#*=}"
      ;;
    --env=*)
      ENV_FILE="${1#*=}"
      ;;
    --with-features=*)
      FEATURES="${1#*=}"
      ;;
    *)
      echo "Unknown parameter: $1"
      exit 1
  esac
  shift
done
VERSION=${VERSION:-"v1.0.1"}
echo "Version: $VERSION"

cp -f ./tests/.env.testing ./laravel-tests/.env
cd ./laravel-tests
git clone https://github.com/pl1998/el-admin.git
composer config repositories.latent path el-admin
composer require latent/el-admin:"$VERSION"
php artisan vendor:publish --provider="Latent\ElAdmin\ElAdminServiceProvider"  --force
php artisan el-admin:install
cd el-admin
composer install
