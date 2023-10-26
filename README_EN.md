<p align="center">
  <img width="200" src="docs/logo.png">
</p>

<p align="center">
<a href="https://packagist.org/packages/pl1998/el-admin"><img src="https://github.styleci.io/repos/707259849/shield?branch=master"/></a>
<img src="https://img.shields.io/badge/license-MIT-green" />
<img src="https://img.shields.io/github/repo-size/pl1998/el-admin">
</p>


## About ElAdmin

English | [简体中文](./README.md)

### Info

> `El-admin` is a third-party background extension package for Laravel. With the front-end scaffolding provided by it, it can be very convenient and fast to build the rbac management background that separates the front and back ends, so that users only care about the business module, without writing permission management.


### Permission based on RBAC model

![](docs/database.png)

### Must
  * PHP  >= 8.0
  * Laravel 9~10

### Installed

```shell
composer require latent/el-admin:dev-master
```

###  Release Config
```shell
php artisan vendor:publish --provider="Latent\ElAdmin\ElAdminServiceProvider"  --force
```

### Shell Build
```shell
php artisan el-admin:install
```

### Other commands
```shell
php artisan el-admin:clear //Clear all menu caches
php artisan el-admin:clear {id} // Clears the specified user menu cache
```


### Example

 * [Vue3 Admin](https://github.com/pl1998/basic)


## License
 MIT License
