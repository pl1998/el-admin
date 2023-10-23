<?php

declare(strict_types=1);

namespace Latent\ElAdmin;

use Illuminate\Testing\Fluent\AssertableJson;


trait TestConfig
{
    /** @var string test host */
    public $host = 'http://0.0.0.0:8000/api/v1/el_admin';
    /**
     * login form.
     *
     * @var string[]
     */
    public $loginForms = [
        'email' => 'admin@gmail.com',
        'password' => '123456',
    ];
    /**
     * @return mixed
     */
    public function getToken() :mixed
    {
        $response = $this->post($this->host.'/login',$this->loginForms);
        $response
            ->assertJson(fn (AssertableJson $json)=>
            $json->has('data')
                ->missing('access_token')
            );
        return $response->json()['data']['access_token'];
    }
}
