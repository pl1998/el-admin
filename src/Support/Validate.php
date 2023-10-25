<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Support;

use Latent\ElAdmin\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

trait Validate
{

    /**
     * Check request params
     *
     * @param array $rules
     * @param array $params
     * @param array $message
     * @return JsonResponse|string|array|null
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
     * Get tables in rules
     * @param string $rules
     * @param string $table
     * @param string $filed
     * @return string
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
