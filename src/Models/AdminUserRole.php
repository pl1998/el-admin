<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Models;

class AdminUserRole extends Admin
{
    /**
     * @var string[]
     */
    protected $fillable = [
      'user_id',
      'role_id',
    ];
}
