<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Controller;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Latent\ElAdmin\Helpers;
use Latent\ElAdmin\Services\Permission;

class AuthController extends Controller
{
    use Permission;

    protected $guard;

    public function __construct()
    {
        $this->guard = config('el_admin.guard');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $params = request()->post();
        $validate = Validator::make($params,[
            'email' => 'required|email',
            'password' => 'required|min:6|max:20'
        ]);
        if($validate->fails()) return  $this->fail($validate->errors()->first());

        if (! $token = auth($this->guard)->attempt(Arr::only($params,['email','password']))) {
            return $this->fail(trans('el_admin::auth.login_error'));
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth($this->getUserAllMenus())->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth($this->guard)->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth($this->guard)->factory()->getTTL() * 60
        ]);
    }

}
