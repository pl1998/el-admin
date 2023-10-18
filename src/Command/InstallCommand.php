<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Command;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Latent\ElAdmin\Models\ElAdminSeeder;

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
     *
     * @return int
     */
    public function handle()
    {
        // release jwt config
        Artisan::call('vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"');
        Artisan::call('vendor:publish --tag=scribe-config');

        Artisan::call('migrate');
        Artisan::call('jwt:secret');

        (new ElAdminSeeder())
            ->run();

        $this->info('build Successfully installed');

        return Command::SUCCESS;
    }
}
