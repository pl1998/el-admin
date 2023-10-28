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
use Latent\ElAdmin\Enum\ModelEnum;
use Latent\ElAdmin\Exceptions\ValidateException;
use Latent\ElAdmin\Services\AuthServices;
use Latent\ElAdmin\Services\Permission;
use Latent\ElAdmin\Support\Helpers;
use Psr\SimpleCache\InvalidArgumentException;

class AuthController extends Controller
{
    use Permission;

    /**
     * User guard.
     */
    protected string $guard;

    public function __construct()
    {
        $this->guard = (string) config('el_admin.guard');
    }

    /**
     * User login.
     *
     * @throws ValidateException
     */
    public function login(): JsonResponse
    {
        $params = $this->validator([
            'email' => 'required|email',
            'password' => 'required|min:6|max:20',
        ]);
        if (! $token = auth($this->guard)->attempt([
            'email' => $params['email'],
            'password' => $params['password'],
            'status' => ModelEnum::NORMAL]
        )) {
            return $this->fail(trans('el_admin.login_error'));
        }

        return (new AuthServices())->respondWithToken((string) $token);
    }

    /**
     * Get the authenticated User.
     *
     * @throws InvalidArgumentException
     * @throws ValidateException
     */
    public function me(): JsonResponse
    {
        $params = $this->validator([
            'is_menus' => 'int|in:0,1',
        ]);
        $user = auth($this->guard)->user()?->toArray();
        if (! empty($params['is_menus'])) {
            [$menus, $nodes] = $this->getUserMenusAndNode();
            $menus = Helpers::getTree($menus);
            $nodes = Helpers::getTree($nodes);
            $user = array_merge($user, ['menus' => $menus, 'nodes' => $nodes]);
        }

        return $this->success($user);
    }

    public function logout(): JsonResponse
    {
        auth($this->guard)->logout();

        return $this->success();
    }

    /**
     * Refresh token.
     */
    public function refresh(): JsonResponse
    {
        return (new AuthServices())->respondWithToken((string) auth($this->guard)->refresh());
    }
}
