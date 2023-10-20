<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Support;

use Latent\ElAdmin\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

trait Validate
{

    /**
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
     * @param string $rules
     * @param string $table
     * @param int $id
     * @return string
     */
    public function getTableRules(string $rules,string $table, int $id = 0): string
    {
        $table = config('el_admin.database.'.$table);
        $conn = config('el_admin.database.connection');
        if($id) {
            return "$rules:$conn.$table,".$id;
        }
        return "$rules:$conn.$table";
    }
}
