<?php

declare(strict_types=1);

namespace Latent\ElAdmin;

use Tests\TestCase;

class UserTest extends TestCase
{
    use TestConfig;

    /**
     * @return void
     *
     * @throws \Exception
     */
    public function testUserStore()
    {
        $token = $this->getToken();

        $this->withHeader('Authorization:',"Bearer $token")->postJson($this->host.'/user',[
            'email' => time().'test@qq.com',
            'name' => time().'demo',
            'password' => 'demo123',
            'repeated_password' => 'demo123',
        ])   ->assertStatus(201)
            ->assertJsonPath('status',200);
    }
    /**
     * @return void
     *
     * @throws \Exception
     */
    public function testUserUpdate()
    {
        $token = $this->getToken();

        $this->withHeader('Authorization:',"Bearer $token")->putJson($this->host.'/user',[
            'id'    =>2,
            'email'    => time().'test1@qq.com',
            'name'     => time().'demo1',
            'password' => 'demo123',
            'repeated_password' => 'demo123',
        ])   ->assertStatus(201)
            ->assertJsonPath('status',200);
    }
}
