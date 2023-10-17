<?php

declare(strict_types=1);

namespace ElAdmin\LaravelVueAdmin\Provider;

use ElAdmin\LaravelVueAdmin\Command\InstallCommand;
use Illuminate\Support\ServiceProvider;

class ElAdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     * @return void
     */
    public function boot(): void
    {
        // release el-admin config
        $this->publishes([
            __DIR__.'/../../config/el_admin.php' => config_path('el_admin.php'),
        ]);
        // register routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
        // registered migrations sql files
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        // register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class
            ]);
        }
    }
}
