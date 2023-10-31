<p align="center">
  <img width="200" src="./docs/logo.png">
</p>

<p align="center">

<a href="https://github.com/pl1998/el-admin/actions/workflows/main.yml"><img src="https://github.com/pl1998/el-admin/actions/workflows/main.yml/badge.svg"></a>
<a href="https://packagist.org/packages/pl1998/el-admin"><img src="https://github.styleci.io/repos/707259849/shield?branch=master"/></a>
<img src="https://img.shields.io/badge/license-MIT-green" />
<img src="https://img.shields.io/github/repo-size/pl1998/el-admin">
</p>

## About ElAdmin

简体中文 | [English](./README_EN.md)

### 简介

> El-admin 是一个Laravel的后台权限扩展包，它提供了权限管理必要的 `API`。配合它提供的前端脚手架，可以很方便快速的搭建前后端分离的rbac管理后台。


### 基于RBAC模型权限

![](docs/database.png)


### 依赖
* PHP  >= 8.0
* Laravel 9~10

### 安装

```shell
composer require latent/el-admin:dev-master
```

###  配置发布
```shell
php artisan vendor:publish --provider="Latent\ElAdmin\ElAdminServiceProvider"  --force
```

### 执行构建脚本
```shell
php artisan el-admin:install
```

### 其它命令
```shell
php artisan el-admin:clear //清除全部菜单缓存
php artisan el-admin:clear {id} //清除指定用户菜单缓存
```

### 示例 

[Vue3实现的管理后台](https://github.com/pl1998/basic)

## License
MIT License
