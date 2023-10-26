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

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AdminRole extends Admin
{
    /** @var string[] */
    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    /**
     * Get User Roles.
     */
    public function menus(): BelongsToMany
    {
        $pivotTable = config('el_admin.database.menus_model');

        $table = config('el_admin.database.role_menus_model');

        return $this->belongsToMany($pivotTable, $table, 'role_id', 'menu_id')
            ->withTimestamps();
    }
}
