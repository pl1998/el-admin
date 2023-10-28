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

namespace Latent\ElAdmin\Support;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Latent\ElAdmin\Exceptions\ValidateException;

trait Validate
{
    /**
     * Check request params.
     *
     * @throws ValidateException
     */
    public function validator(array $rules, array $params = [], array $message = []): JsonResponse|string|array|null
    {
        if (empty($params)) {
            $params = request()->input();
        }

        $validate = Validator::make($params, $rules, $message);
        if ($validate->fails()) {
            throw new ValidateException($validate->errors()->first());
        }

        return $params;
    }

    /**
     * Get tables in rules.
     */
    public function getTableRules(string $rules, string $table, string $filed = ''): string
    {
        $table = config('el_admin.database.'.$table);
        $conn = config('el_admin.database.connection');
        if (! empty($filed)) {
            return "$rules:$conn.$table,".$filed;
        }

        return "$rules:$conn.$table";
    }
}
