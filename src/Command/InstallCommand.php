<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
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
        if (!file_exists(base_path().'/.env')) {
            ShellCommand::execute('cp .env.example .env');
            Artisan::call('key:generate');
        }
        Artisan::call('jwt:secret');
        // database migration
        Artisan::call('migrate');
        // Initialize the data population
        (new ElAdminSeeder())
            ->run();

        $this->info('build Successfully installed');

        return Command::SUCCESS;
    }
}
