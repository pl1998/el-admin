<?php

declare(strict_types=1);


namespace ElAdmin\LaravelVueAdmin\Models;

use ElAdmin\LaravelVueAdmin\Helpers;
use Illuminate\Database\Eloquent\Model;

trait GetModelTraits
{
    /**
     * Get user models
     * @return Model|AdminUser
     */
    public function getUserModel() :Model|AdminUser
    {
        return (new (Helpers::ElConfig('database.users_model')));
    }
}
