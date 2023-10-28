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
