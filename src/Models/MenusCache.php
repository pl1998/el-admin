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

namespace Latent\ElAdmin\Models;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use Latent\ElAdmin\Enum\ModelEnum;
use Psr\SimpleCache\InvalidArgumentException;

class MenusCache
{
    /**
     * Set Cache.
     *
     * @throws InvalidArgumentException
     */
    public static function setCache($userId, $data): void
    {
        if (config('el_admin.menus.cache')) {
            self::getCache()->set(self::getPrefix($userId), $data, config('el_admin.menus.ttl') * 60);
        }
    }

    /**
     * Get cache prefix.
     */
    public static function getPrefix($userId): string
    {
        return config('el_admin.menus.prefix').$userId;
    }

    /**
     * Get cache service.
     */
    public static function getCache(): Repository
    {
        return Cache::store(config('el_admin.menus.cache_driver'));
    }

    /**
     * Delete user menus cache.
     *
     * @throws InvalidArgumentException
     */
    public static function delMenusCache(int $userId = 0): void
    {
        if ($userId) {
            self::getCache()
                ->delete(self::getPrefix($userId));
        } else {
            (new (config('el_admin.database.users_model')))
                ->where('status', ModelEnum::NORMAL)
                ->pluck('id')
                ->map(function ($id) {
                    self::getCache()
                        ->delete(self::getPrefix($id));
                });
        }
    }
}
