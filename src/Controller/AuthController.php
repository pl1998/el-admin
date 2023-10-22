<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Latent\ElAdmin\Exceptions\ValidateException;
use Latent\ElAdmin\Services\AuthServices;
use Latent\ElAdmin\Services\Permission;
use Latent\ElAdmin\Support\Helpers;
use Psr\SimpleCache\InvalidArgumentException;

class AuthController extends Controller
{
    use Permission;

    /** @var string|mixed */
    protected string $guard;

    public function __construct()
    {
        $this->guard = config('el_admin.guard');
    }

    /**
     * @throws ValidateException
     */
    public function login(): JsonResponse
    {
        $params = $this->validator([
            'email' => 'required|email',
            'password' => 'required|min:6|max:20',
        ]);

        if (!$token = auth($this->guard)->attempt(Arr::only($params, ['email', 'password']))) {
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
        if (!empty($params['is_menus'])) {
            list($menus, $nodes) = $this->getUserMenusAndNode();
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
     * Refresh a token.
     */
    public function refresh(): JsonResponse
    {
        return (new AuthServices())->respondWithToken((string) auth($this->guard)->refresh());
    }
}
