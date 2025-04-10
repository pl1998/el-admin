#!/usr/bin/env bash

# 兼容旧版bash：移除pipefail，改用传统错误处理
set -eu  # 保留基本严格模式（出错即停+禁止空变量）

BASE_DIR="./laravel-tests"
EL_ADMIN_DIR="${BASE_DIR}/el-admin"

# 1. 环境准备（带错误检查）
echo "🚀 初始化测试环境..."
if [ -d "$BASE_DIR" ]; then
  rm -rf "$BASE_DIR" || { echo "❌ 清理旧目录失败"; exit 1; }
fi
mkdir -p "$BASE_DIR" || exit 1

# 2. 复制配置（安全模式）
echo "🔄 复制测试配置..."
if [ -f "$BASE_DIR/.env" ]; then
  echo "ℹ️ 已有.env，跳过复制"
else
  cp ./tests/.env.testing "$BASE_DIR/.env" || { echo "❌ 复制配置失败"; exit 1; }
fi

# 3. 克隆仓库（带版本控制）
echo "📥 克隆el-admin（v1.0.1）..."
if [ ! -d "$EL_ADMIN_DIR" ]; then
  git clone --branch=v1.0.1 --depth=1 https://github.com/pl1998/el-admin.git "$EL_ADMIN_DIR" || {
    echo "❌ 克隆失败，检查网络或仓库地址";
    exit 1;
  }
else
  echo "ℹ️ 已存在el-admin，跳过克隆"
fi

# 4. 安装依赖（分步错误处理）
cd "$BASE_DIR" || { echo "❌ 进入目录失败"; exit 1; }
composer install --no-interaction --prefer-dist || {
  echo "❌ Composer安装失败，检查依赖";
  exit 1;
}

# 5. 安装el-admin（带重试）
echo "📦 安装el-admin插件..."
ATTEMPTS=0
MAX_ATTEMPTS=3
while (( ATTEMPTS < MAX_ATTEMPTS )); do
  composer require latent/el-admin:v1.0.1 \
    --repository-url="path://$(realpath "$EL_ADMIN_DIR")" \
    --no-update --no-interaction && break

  ATTEMPTS=$((ATTEMPTS+1))
  if (( ATTEMPTS < MAX_ATTEMPTS )); then
    echo "⚠️ 第${ATTEMPTS}次重试（等待2秒）"
    sleep 2
  fi
done || {
  echo "❌ 三次安装均失败，终止脚本"
  exit 1
}

composer update latent/el-admin --no-interaction || exit 1

# 6. 执行初始化（传统错误检查）
echo "🚦 执行初始化..."
if ! php artisan el-admin:install --force; then
  echo "❌ 初始化失败，检查数据库配置或权限"
  exit 1
fi

# 7. 清理提示（可选）
echo -e "\n✅ 全部完成！测试环境在：$(realpath "$BASE_DIR")"
echo "ℹ️ 如需清理el-admin.git：rm -rf $EL_ADMIN_DIR/.git"
