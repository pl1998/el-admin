<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Models;

class AdminMenu extends Admin
{
    /** @var string[] */
    protected $fillable = [
        'parent_id',
        'name',
        'icon',
        'route_name',
        'route_path',
        'component',
        'sort',
        'type',
        'method',
        'hidden',
        'perm',
    ];
}
