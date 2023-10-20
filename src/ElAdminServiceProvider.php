<?php

declare(strict_types=1);

namespace Latent\ElAdmin;

use Illuminate\Contracts\Support\DeferrableProvider;
use Latent\ElAdmin\Command\InstallCommand;
use Illuminate\Support\ServiceProvider;
use Latent\ElAdmin\Command\MenuCacheCommand;

class ElAdminServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // register merge config/auth.php
        $this->mergeConfigFrom(
            __DIR__.'/../config/auth.php', 'auth'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadConfigs();
        $this->loadRoutes();
        $this->loadTranslations();
        $this->loadMigrations();
        $this->loadResources();
        $this->runningCommands();
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            InstallCommand::class,
            MenuCacheCommand::class,
        ];
    }

    /**
     * Release config.
     */
    protected function loadConfigs(): void
    {
        $this->publishes([__DIR__.'/../config/auth.php' => config_path('auth.php')]);
        $this->publishes([__DIR__.'/../config/scribe.php' => config_path('scribe.php')]);
        $this->publishes([__DIR__.'/../config/el_admin.php' => config_path('el_admin.php')]);
    }

    /**
     * Release routes.
     */
    protected function loadRoutes(): void
    {
        // register routes
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        // release routes
        $this->publishes([
            __DIR__.'/../routes/api.php' => base_path().'/routes/admin.php',
        ]);
    }

    /**
     * Release lang.
     */
    protected function loadTranslations(): void
    {
//        // release lang
//        $this->publishes([
//            __DIR__.'/../lang' => $this->app->langPath(),'el-admin-lang'
//        ]);
    }

    /**
     * Registered migrations database.
     */
    protected function loadMigrations(): void
    {
        // registered migrations sql files
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../migrations' => database_path().'/migrations',
        ]);
    }

    /**
     * release resources.
     */
    protected function loadResources(): void
    {
        // logo
        $this->publishes([
            __DIR__.'/../docs/logo.png' => public_path().'/logo.png',
        ]);
    }

    /**
     * register commands.
     */
    protected function runningCommands(): void
    {
        // register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                MenuCacheCommand::class,
            ]);
        }
    }
}
