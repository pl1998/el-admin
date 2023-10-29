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

namespace Latent\ElAdmin\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Latent\ElAdmin\Enum\ModelEnum;
use Latent\ElAdmin\Exceptions\ValidateException;
use Latent\ElAdmin\Models\ModelTraits;
use Latent\ElAdmin\Rules\CheckPassword;
use Latent\ElAdmin\Services\UserService;
use Throwable;

class UsersController extends Controller
{
    use ModelTraits;

    /**
     * @throws ValidateException
     */
    public function index(UserService $userService): JsonResponse
    {
        $params = $this->validator([
            'name' => 'string|min:1,max:20',
            'email' => 'string|min:1,max:30',
            'page' => 'integer',
            'page_size' => 'integer',
        ]);

        return $this->success($userService->list($params));
    }

    public function store(UserService $userService): JsonResponse
    {
        try {
            $params = $this->validator([
                'name' => 'required|string|'.$this->getTableRules('unique', 'users_table'),
                'email' => 'required|email|'.$this->getTableRules('unique', 'users_table'),
                'password' => 'required|min:6|max:20|confirmed:password_confirmation',
                'password_confirmation' => 'required|min:6|max:20',
                'role' => 'array',
            ]);

            $userService->add($params);
        } catch (Throwable $e) {
            return $this->fail($e->getMessage().$e->getFile().$e->getLine());
        }

        return $this->success();
    }

    /**
     * @throws Throwable
     * @throws ValidateException
     */
    public function update($id, UserService $userService): JsonResponse
    {
        $params = $this->validator([
            'id' => 'required|'.$this->getTableRules('exists', 'users_table'),
            'name' => 'string|'.$this->getTableRules('unique', 'users_table', 'id'),
            'email' => 'email|'.$this->getTableRules('unique', 'users_table', 'id'),
            'password' => [new CheckPassword(), 'confirmed:password_confirmation'],
            'password_confirmation' => [new CheckPassword()],
            'rule' => 'array',
            'status' => ['int', Rule::in([ModelEnum::NORMAL, ModelEnum::FORBIDDEN])],
        ], $this->mergeParams(['id' => $id]));

        $userService->update($params);

        return $this->success();
    }

    public function destroy($id, UserService $userService): JsonResponse
    {
        $userService->destroy((int) $id);

        return $this->success();
    }
}
