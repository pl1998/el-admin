<?php

declare(strict_types=1);

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
     * @param $key
     * @return false|string
     */
    public function getIpAttribute($key)
    {
        if(is_numeric($key)) {
            return long2ip($key);
        }
        return  $key;
    }
}
