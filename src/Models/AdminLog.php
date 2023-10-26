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

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'user_name',
        'param',
        'method',
        'ip',
        'path',
        'device',
        'device_info',
        'is_danger',
        'ip_address',
    ];

    /**
     * @return false|string
     */
    public function getIpAttribute($key): bool|string
    {
        if (is_numeric($key)) {
            return long2ip($key);
        }

        return $key;
    }
}
