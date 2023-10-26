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

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Latent\ElAdmin\Factories\ModelFactory;

trait ModelTraits
{
    /**
     * @throws BindingResolutionException
     */
    public function getUserModel(): Model
    {
        return ModelFactory::create('users_model');
    }

    /**
     * @throws BindingResolutionException
     */
    public function getRoleModel(): Model
    {
        return ModelFactory::create('roles_model');
    }

    /**
     * @throws BindingResolutionException
     */
    public function getRoleMenusModel(): Model
    {
        return ModelFactory::create('role_menus_model');
    }

    /**
     * @throws BindingResolutionException
     */
    public function getMenusModel(): Model
    {
        return ModelFactory::create('menus_model');
    }

    /**
     * @throws BindingResolutionException
     */
    public function getUserRolesModel(): Model
    {
        return ModelFactory::create('user_roles_model');
    }

    /**
     * @throws BindingResolutionException
     */
    public function getLogModel(): Model
    {
        return ModelFactory::create('log_model');
    }
}
