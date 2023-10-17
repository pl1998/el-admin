## About ElAdmin

### ElAdmin Authorization services depend on `laravel/socialite`。But these are all replaceable。
```shell
composer require laravel/socialite
```

### Installation

```shell
composer require "ElAdmin/laravel-vue-admin"
```

###  publish config
```shell
php artisan vendor:publish --provider="ElAdmin\LaravelVueAdmin\Provider\ElAdminServiceProvider"
```

### execute migrate
```shell
php artisan migrate
```

## License
