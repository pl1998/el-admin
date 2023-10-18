<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Controller;

use Illuminate\Support\Arr;
use Latent\ElAdmin\Models\GetModelTraits;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use GetModelTraits;

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

        if (! $token = auth(config('el_admin.guard'))->attempt(Arr::only($params,['email','password']))) {
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
        return response()->json(auth(config('el_admin.guard'))->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth(config('el_admin.guard'))->refresh());
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
            'expires_in' => auth(config('el_admin.guard'))->factory()->getTTL() * 60
        ]);
    }

}
