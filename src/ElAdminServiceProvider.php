<?php

declare(strict_types=1);

/*
 * This file is part of the latent/el-admin.
 *
 * (c) latent<pltrueover@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Latent\ElAdmin;

use Illuminate\Support\ServiceProvider;
use Latent\ElAdmin\Command\InstallCommand;
use Latent\ElAdmin\Command\MenuCacheCommand;

class ElAdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // register merge config/auth.php
        $this->mergeConfigFrom(
            __DIR__.'/../config/auth.php', 'auth'
        );
    }

    public function boot(): void
    {
        $this->publishesConfigs();
        $this->registerRoutes();
        $this->loadTranslations();
        $this->loadMigrations();
        $this->loadResources();
        $this->runningCommands();
    }

    public function provides(): array
    {
        return [
            InstallCommand::class,
            MenuCacheCommand::class,
        ];
    }

    protected function publishesConfigs(): void
    {
        $this->publishes([__DIR__.'/../config/auth.php' => config_path('auth.php')]);
        $this->publishes([__DIR__.'/../config/el_admin.php' => config_path('el_admin.php')]);
        $this->publishes([__DIR__.'/api.php' => base_path().'/routes/admin.php']);
    }

    protected function registerRoutes(): void
    {
        if (file_exists(base_path().'/routes/admin.php')) {
            $this->loadRoutesFrom(base_path().'/routes/admin.php');
        } else {
            $this->loadRoutesFrom(realpath(__DIR__.'/api.php'));
        }
    }

    protected function loadTranslations(): void
    {
        $this->publishes([
            __DIR__.'/../lang' => lang_path(),
        ]);
    }

    protected function loadMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../migrations' => database_path().'/migrations',
        ]);
    }

    protected function loadResources(): void
    {
        $this->publishes([
            __DIR__.'/../docs/logo.png' => public_path().'/logo.png',
        ]);
    }

    protected function runningCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                MenuCacheCommand::class,
            ]);
        }
    }
}
