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
    public function register() :void
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
        $this->loadConfigs();
        $this->loadRoutes();
        $this->loadTranslations();
        $this->loadMigrations();
        $this->loadResources();
        $this->runningCommands();

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() :array
    {
        return [
            InstallCommand::class,
        ];
    }

    /**
     * Release config
     * @return void
     */
    protected function loadConfigs() :void
    {
        // release el-admin config
        $this->publishes([
            __DIR__.'/../config/el_admin.php' => config_path('el_admin.php'),
        ]);
        // register merge config/auth.php
        $this->publishes([
            __DIR__.'/../config/auth.php' => config_path('auth.php'),
        ]);

    }

    /**
     * Release routes
     * @return void
     */
    protected function loadRoutes() :void
    {
        // register routes
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        // release routes
        $this->publishes([
            __DIR__.'/../routes/api.php' => base_path().'/routes/admin.php'
        ]);

    }

    /**
     * Release lang
     * @return void
     */
    protected function loadTranslations() :void
    {
        // register lang
        $this->loadTranslationsFrom(__DIR__.'/../lang','el_admin');
        // release lang
        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/el_admin'),
        ]);
    }

    /**
     * Registered migrations database
     * @return void
     */
    protected function loadMigrations() :void
    {
        // registered migrations sql files
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../migrations' => database_path().'/migrations',
        ]);
    }

    /**
     * release resources
     * @return void
     */
    protected function loadResources() :void
    {
        // logo
        $this->publishes([
            __DIR__.'/../docs/logo.png' => public_path().'/logo.png',
        ]);
    }

    /**
     * register commands
     * @return void
     */
    protected function runningCommands() :void
    {
        // register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class
            ]);
        }
    }
}
