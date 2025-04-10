#!/usr/bin/env bash

# 严格模式：出错即终止，禁止空变量，严格管道错误
set -euo pipefail

# 定义固定路径（使用相对路径避免硬编码）
BASE_DIR="./laravel-tests"
EL_ADMIN_DIR="${BASE_DIR}/el-admin"

# 1. 准备测试环境
echo "🚀 初始化测试环境..."
# 清理旧测试目录（避免残留）
[ -d "$BASE_DIR" ] && rm -rf "$BASE_DIR"
mkdir -p "$BASE_DIR"

# 2. 复制环境配置（-n 避免覆盖已有文件）
echo "🔄 复制测试配置..."
cp -n ./tests/.env.testing "$BASE_DIR/.env" || true  # 存在则跳过

# 3. 克隆并准备el-admin（仅当不存在时执行）
echo "📥 克隆el-admin仓库（v2.0.0）..."
if [ ! -d "$EL_ADMIN_DIR" ]; then
  git clone --depth=1 --branch=v2.0.0 https://github.com/pl1998/el-admin.git "$EL_ADMIN_DIR"
else
  echo "ℹ️ 检测到已有el-admin目录，跳过克隆"
fi

# 4. 安装依赖（使用临时Composer配置）
echo "⚙️ 安装项目依赖..."
cd "$BASE_DIR" || exit
composer install --no-interaction --prefer-dist

# 5. 配置并安装el-admin（局部配置，不污染全局）
echo "📦 安装el-admin插件..."
composer require latent/el-admin:v2.0.0 \
  --repository-url="path://$(realpath "$EL_ADMIN_DIR")" \
  --no-update \
  --no-interaction

composer update latent/el-admin --no-interaction

# 6. 执行安装流程（添加重试机制）
echo "🚦 执行初始化（最多重试3次）..."
ATTEMPTS=0
MAX_ATTEMPTS=3
until php artisan el-admin:install --force; do
  if (( ATTEMPTS < MAX_ATTEMPTS )); then
    ATTEMPTS=$((ATTEMPTS+1))
    echo "⚠️ 第${ATTEMPTS}次重试..."
    sleep 2
  else
    echo "❌ 安装失败，终止脚本"
    exit 1
  fi
done

# 7. 清理临时文件（可选）
# echo "🧹 清理临时文件..."
# rm -rf "$EL_ADMIN_DIR/.git"

echo "✅ 全部操作完成！测试环境已准备就绪"
