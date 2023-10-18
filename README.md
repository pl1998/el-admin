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

### Add the method to `App\Http\Middleware\Authenticate` 

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

## License
