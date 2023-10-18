<?php

namespace Latent\ElAdmin\Command;

use Illuminate\Console\Command;
use Latent\ElAdmin\Models\MenusCache;

class MenuCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'el-admin:clear {user_id=0}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        MenusCache::delMenusCache((int)$userId);
        if($userId) {
            $this->info("Cleared user_id: $userId menus cache");
        } else{
            $this->info('Cleared all menus cache');
        }
    }
}
