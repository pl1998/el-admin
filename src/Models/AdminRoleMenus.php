<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Models;

use Latent\ElAdmin\Enum\ModelEnum;

class AdminRoleMenus extends Admin
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function menus()
    {
        return $this->hasOne(AdminMenu::class,'id','menu_id')
            ->where('hidden',ModelEnum::NORMAL);
    }
}
