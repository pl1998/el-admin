<?php

declare(strict_types=1);

namespace Latent\ElAdmin;

use Illuminate\Contracts\Support\DeferrableProvider;
use Latent\ElAdmin\Command\InstallCommand;
use Illuminate\Support\ServiceProvider;

class ElAdminServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // register merge config/auth.php
        $this->mergeConfigFrom(
            __DIR__.'/../config/auth.php', 'auth'
        );
    }

    /**
     * Bootstrap services.
     * @return void
     */
    public function boot(): void
    {
        // release el-admin config
        $this->publishes([
            __DIR__.'/../config/el_admin.php' => config_path('el_admin.php'),
        ]);
        // register merge config/auth.php
        $this->publishes([
            __DIR__.'/../config/auth.php' => config_path('auth.php'),
        ]);
        // register routes
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        // registered migrations sql files
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            InstallCommand::class,
        ];
    }
}
