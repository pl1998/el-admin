<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Support;

use Latent\ElAdmin\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

trait Validate
{
    /**
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
     * @param int $id
     */
    public function getTableRules(string $rules, string $table, string $filed = ''): string
    {
        $table = config('el_admin.database.'.$table);
        $conn = config('el_admin.database.connection');
        if (!empty($filed)) {
            return "$rules:$conn.$table,".$filed;
        }

        return "$rules:$conn.$table";
    }
}
