<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Models;

use Latent\ElAdmin\Enum\ModelEnum;

class AdminRole extends Admin
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allRoleMenus()
    {
        return $this->hasMany(AdminRoleMenus::class,'role_id','id')->where('status',ModelEnum::NORMAL);
    }

    protected $fillable = [
        'name',
        'status'
    ];
}
