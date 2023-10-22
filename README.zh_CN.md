<p align="center">
  <img width="200" src="./docs/logo.png">
</p>

<p align="center">

<a href="https://packagist.org/packages/pl1998/el-admin"><img src="https://img.shields.io/badge/php-v8.0+-blue" /></a>
<a href="https://packagist.org/packages/pl1998/el-admin"><img src="https://github.styleci.io/repos/707259849/shield?branch=master"/></a>
<img src="https://img.shields.io/badge/license-MIT-green" />
<img src="https://img.shields.io/github/repo-size/pl1998/el-admin">
</p>

## About ElAdmin

[English](./README.md) | 简体中文

### 简介

> El-admin 是一个Laravel的第三方后台扩展包。配合它提供的前端脚手架，可以很方便快速的搭建前后端分离的rbac管理后台，让使用者只关心业务模块，不用编写权限管理。


### 基于RBAC模型权限

![](docs/database.png)


### 依赖
* PHP  >= 8.0
* Laravel 9~10

### 安装

```shell
composer require latent/el-admin
```

###  配置发布
```shell
php artisan vendor:publish --provider="Latent\ElAdmin\ElAdminServiceProvider"  --force
```

### 执行构建脚本
```shell
php artisan el-admin:install
php artisan route:cache
```

### 其它命令
```shell
php artisan el-admin:el-admin:clear //清除全部菜单缓存
php artisan el-admin:el-admin:clear {id} //清除指定用户菜单缓存
```

### 兼容
> 修改 `config/el_admin.php` 将 `guard` 改成 `api`
> 或者 `App\Http\Middleware\Authenticate` 加入这段代码。
> 该目的在web接口和后台接口在同一项目时后台jwt配置不占用api的配置。
```php
 /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // or $guards = [config('el_admin.guard')];
        $guards = array_merge($guards,[config('el_admin.guard')]);
      
        $this->authenticate($request, $guards);

        return $next($request);
    }
```

### 示例 

[Vue3实现的管理后台](https://github.com/pl1998/basic)

## License
MIT License
