<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Models;

use Latent\ElAdmin\Helpers;
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
