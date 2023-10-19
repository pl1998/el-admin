<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Latent\ElAdmin\Helpers;
use Latent\ElAdmin\Services\AuthServices;
use Latent\ElAdmin\Services\Permission;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\BodyParam;

#[Group("用户登录相关", "用户登录相关接口")]
#[Subgroup("Auth", "登录控制器")]
class AuthController extends Controller
{
    use Permission;

    protected string $guard;

    public function __construct()
    {
        $this->guard = config('el_admin.guard');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */

    #[BodyParam("email", "string", "邮箱")]
    #[BodyParam("password", "string", "密码")]
    #[Response(<<<JSON
{
    "access_token": "token",
    "token_type": "bearer",
    "expires_in": 216000
}
JSON)]
    public function login() :JsonResponse
    {
        $params = $this->validator([
            'email' => 'required|email',
            'password' => 'required|min:6|max:20'
        ]);

        if (! $token = auth($this->guard)->attempt(Arr::only($params,['email','password']))) {
            return $this->fail(trans('admin::auth.login_error'));
        }
        return (new AuthServices())->respondWithToken((string)$token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */

    #[Authenticated]
    #[Response(<<<JSON
{
    "data": {
        "id": 1,
        "name": "Administrator",
        "email": "admin@gamil.com",
        "avatar": "http://dev.admin.com/logo.png",
        "created_at": "2023-10-18T12:53:45.000000Z",
        "updated_at": "2023-10-18T12:53:45.000000Z",
        "menus": [
        ],
        "nodes": []
    },
    "message": "success",
    "status": 200
}
JSON)]
    public function me() :JsonResponse
    {
        $user = auth($this->guard)->user()?->toArray();
        list($menus,$nodes) = $this->getUserMenusAndNode();
        $menus = Helpers::getTree($menus);
        $nodes = Helpers::getTree($nodes);
        return $this->success(array_merge($user,['menus' => $menus,'nodes' => $nodes]));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */

    #[Authenticated]
    #[Response(<<<JSON
{
    "data": [],
    "message": "success",
    "status": 200
}
JSON)]
    public function logout() :JsonResponse
    {
        auth($this->guard)->logout();

        return $this->success();
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */

    #[Authenticated]
    #[Response(<<<JSON
{
    "access_token": "token",
    "token_type": "bearer",
    "expires_in": 216000
}
JSON)]
    public function refresh() :JsonResponse
    {
        return (new AuthServices())->respondWithToken((string)(auth($this->guard)->refresh()));
    }


}
