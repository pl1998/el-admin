<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Latent\ElAdmin\Enum\ModelEnum;

class AdminRoleMenu extends Model
{
    public function menus(): HasOne
    {
        return $this->hasOne(config('el_admin.database.menus_model'), 'id', 'menu_id')
            ->where('hidden', ModelEnum::NORMAL);
    }
}
