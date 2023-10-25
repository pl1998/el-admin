<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Factories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class ModelFactory
{
    /**
     * Get model factory.
     *
     * @throws BindingResolutionException
     */
    public static function create($modelName): Model
    {
        $modelClass = config("el_admin.database.$modelName");

        if ($modelClass && is_subclass_of($modelClass, Model::class)) {
            return app()->make($modelClass);
        }
        throw new InvalidArgumentException("Invalid model name: $modelName");
    }
}
