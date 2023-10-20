<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Models;

use Illuminate\Database\Eloquent\Model;

trait GetModelTraits
{
    /**
     * Get user models.
     */
    public function getUserModel(): Model
    {
        return new (config('el_admin.database.users_model'));
    }

    /**
     * Get role models.
     */
    public function getRoleModel(): Model
    {
        return new (config('el_admin.database.roles_model'));
    }

    /**
     * Get role menus models.
     */
    public function getRoleMenusModel(): Model
    {
        return new (config('el_admin.database.role_menus_model'));
    }

    /**
     * Get  menus models.
     */
    public function getMenusModel(): Model
    {
        return new (config('el_admin.database.menus_model'));
    }

    /**
     * Get  menus models.
     */
    public function getUserRolesModel(): Model
    {
        return new (config('el_admin.database.user_roles_model'));
    }

    /**
     * get log models.
     */
    public function getLogModel(): Model
    {
        return new (config('el_admin.database.log_model'));
    }
}
