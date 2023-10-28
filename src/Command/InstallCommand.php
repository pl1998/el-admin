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

namespace Latent\ElAdmin\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Latent\ElAdmin\Models\ElAdminSeeder;
use Latent\ElAdmin\Support\ShellCommand;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'el-admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'admin install script command';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! file_exists(base_path().'/.env')) {
            ShellCommand::execute('cp .env.example .env');
            Artisan::call('key:generate');
        }

        $envContents = File::get(base_path('.env'));

        // JWT_SECRET doesn't exist or doesn't have a value in the .env file.
        if (false === strpos($envContents, 'JWT_SECRET=') || empty(env('JWT_SECRET'))) {
            Artisan::call('jwt:secret');
        }

        // database migration
        Artisan::call('migrate');
        // Initialize the data population
        (new ElAdminSeeder())
            ->run();

        $this->info('build Successfully installed');

        return Command::SUCCESS;
    }
}
