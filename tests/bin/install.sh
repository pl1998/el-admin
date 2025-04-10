#!/usr/bin/env bash
cp -f ./tests/.env.testing ./laravel-tests/.env
cd ./laravel-tests

# 克隆并切换到 v1.0.1 标签（必须确保仓库存在此标签）
git clone https://github.com/pl1998/el-admin.git
cd el-admin
git checkout 1.0.1  # 关键步骤：检出目标版本
cd ..

# 重新配置路径仓库（此时本地仓库已包含 v1.0.1 代码）
composer config repositories.latent path el-admin
composer require latent/el-admin:v1.0.1 --no-update  # 避免自动更新

# 后续步骤保持不变
php artisan vendor:publish --provider="Latent\ElAdmin\ElAdminServiceProvider"  --force
php artisan el-admin:install
cd el-admin
composer install
