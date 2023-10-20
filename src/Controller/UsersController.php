<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Controller;

use Latent\ElAdmin\Models\GetModelTraits;
use Illuminate\Http\JsonResponse;
use Latent\ElAdmin\Services\UserService;
use Throwable;

class UsersController extends Controller
{
    use GetModelTraits;

    public function index(UserService $userService): JsonResponse
    {
        $params = $this->validator([
            'name' => 'string|min:1,max:20',
            'page' => 'integer',
            'page_size' => 'integer',
        ]);

        return $this->success($userService->list($params));
    }

    /**
     * @throws Throwable
     */
    public function store(UserService $userService): JsonResponse
    {
        $params = $this->validator([
            'name' => 'required|string|unique:connection.'.config('el_admin.database.connection').
                ','.config('el_admin.database.users_table'),
            'email' => 'required|email|unique:connection.'.config('el_admin.database.connection').',
            '.config('el_admin.database.users_table'),
            'password' => 'required|min:6|max:20',
            'rule' => 'array',
        ]);

        $userService->add($params);

        return $this->success();
    }

    /**
     * @throws Throwable
     */
    public function update($id, UserService $userService): JsonResponse
    {
        $params = $this->validator([
            'id' => 'required|string|exists:connection.'.config('el_admin.database.connection').
                ','.config('el_admin.database.users_table'),
            'name' => 'required|string|unique:connection.'.config('el_admin.database.connection').
                ','.config('el_admin.database.users_table'),
            'email' => 'required|email|unique:connection.'.config('el_admin.database.connection').',
            '.config('el_admin.database.users_table'),
            'password' => 'required|min:6|max:20',
            'rule' => 'array',
        ], array_merge(request()->post(), ['id' => $id]));

        $userService->update($params);

        return $this->success();
    }

    /**
     * delete a user.
     */
    public function destroy($id): JsonResponse
    {
        $this->getUserModel()->where('id', $id)->delete();

        return $this->success();
    }
}
