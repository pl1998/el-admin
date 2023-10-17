<?php

declare(strict_types=1);


namespace ElAdmin\LaravelVueAdmin\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['admin.login']]);
    }

    public function login()
    {
        return $this->success();
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
