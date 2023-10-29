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

namespace Latent\ElAdmin\Tests;

class UsersTest extends TestCase
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

        $this->withHeader('Authorization', "Bearer $token")->post('/user', [
            'email' => time().'test@qq.com',
            'name' => time().'demo',
            'password' => 'demo123',
            'password_confirmation' => 'demo123',
        ]);
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }

    /**
     * @return void
     *
     * @throws \Exception
     */
    public function testUserUpdate()
    {
        $token = $this->getToken();

        $this->withHeader('Authorization:', "Bearer $token")->put('/user/2', [
            'id' => 2,
            'email' => time().'t@qq.com',
            'name' => time().'demo2',
            'password' => 'demo123',
            'password_confirmation' => 'demo123',
        ]);
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }
}
