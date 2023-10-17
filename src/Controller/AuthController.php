<?php

declare(strict_types=1);


namespace ElAdmin\LaravelVueAdmin\Controller;

use ElAdmin\LaravelVueAdmin\Enum\ModelEnum;
use ElAdmin\LaravelVueAdmin\Models\GetModelTraits;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
class AuthController extends Controller
{
    use GetModelTraits;

    /**
     * @return JsonResponse
     */
    public function login() :JsonResponse
    {
        $params = request()->post();
        $validate = Validator::make($params,[
            'email' => 'required|email',
            'password' => 'required|min:6|max:20'
        ]);
        if($validate->fails()) return  $this->fail($validate->errors()->first());

        $user = $this->getUserModel()
            ->where('email',$params['email'])
            ->where('status',ModelEnum::NORMAL)
            ->first();

        if(!$user || !Hash::check($params['password'],$user->password)) {
            return $this->fail('账号或密码错误');
        }
        $token = $user->createToken($user->email);

        return $this->success([
            'token' => $token,
            'ttl'   => config('sanctum.expiration') ?? 0
        ]);
    }

    public function logout()
    {

    }

    public function refresh()
    {

    }

    public function me()
    {

    }
}
