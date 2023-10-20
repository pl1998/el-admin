<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    protected $casts = [
        'param' => 'array',
    ];

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
}
