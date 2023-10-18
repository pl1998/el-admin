## About ElAdmin

### ElAdmin Authorization services depend on `tymon/jwt-auth`。But these are all replaceable。
```shell
composer require tymon/jwt-auth
```

### Installation

```shell
composer require "pl1998/el-admin"
```

###  publish config
```shell
php artisan vendor:publish --provider="Latent\ElAdmin\ElAdminServiceProvider"
```

### build
```shell
php artisan el-admin:install
```

## License
