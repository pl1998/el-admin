<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Models;

use Latent\ElAdmin\Enum\ModelEnum;

class AdminRoleMenu extends Admin
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function menus()
    {
        return $this->hasOne(config('el_admin.database.menus_model'), 'id', 'menu_id')
            ->where('hidden', ModelEnum::NORMAL);
    }
}
