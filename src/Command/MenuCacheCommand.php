<?php

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
use Latent\ElAdmin\Models\MenusCache;
use Psr\SimpleCache\InvalidArgumentException;

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
     * @throws InvalidArgumentException
     */
    public function handle(): void
    {
        $userId = $this->argument('user_id');
        MenusCache::delMenusCache((int) $userId);
        if ($userId) {
            $this->info("Cleared user_id: $userId menus cache");
        } else {
            $this->info('Cleared all menus cache');
        }
    }
}
