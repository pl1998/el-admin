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
        return $this->hasMany(config('el_admin.database.role_menus_model'),'role_id','id')
            ->where('status',ModelEnum::NORMAL);
    }

    /** @var string[]  */
    protected $fillable = [
        'name',
        'status'
    ];
}
