<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Models;

use Illuminate\Database\Query\Builder;
use Latent\ElAdmin\Helpers;
use Illuminate\Database\Eloquent\Model;

trait GetModelTraits
{
    /**
     * Get user models
     * @return Builder
     */
    public function getUserModel() :Builder
    {
        return (new (config('el_admin.database.users_model')));
    }

    /**
     * Get role models
     * @return Model
     */
    public function getRoleModel():Model
    {
        return (new (config('el_admin.database.roles_model')));
    }
    /**
     * Get role menus models
     * @return Model
     */
    public function getRoleMenusModel():Model
    {
        return (new (config('el_admin.database.role_menus_model')));
    }

    /**
     * Get  menus models
     * @return Model
     */
    public function getMenusModel():Model
    {
        return (new (config('el_admin.database.menus_model')));
    }

    /**
     * Get  menus models
     * @return Model
     */
    public function getUserRolesModel():Model
    {
        return (new (config('el_admin.database.user_roles_model')));
    }
}
