<?php

/*
 * This file is part of the latent/el-admin.
 *
 * (c) latent<pltrueover@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Latent\ElAdmin\Tests;

class RolesTest extends TestCase
{
    use TestConfig;

    /**
     * @return void
     *
     * @throws \Exception
     */
    public function testRoleStore()
    {
        $token = $this->getToken();

        $this->withHeader('Authorization', "Bearer $token")->post('/role', [
            'name' => time().'role',
            'menu' => [1, 2],
        ]);
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }

    /**
     * @return void
     *
     * @throws \Exception
     */
    public function testRoleUpdate()
    {
        $token = $this->getToken();

        $this->withHeader('Authorization', "Bearer $token")->put('/role/2', [
            'name' => time().'role',
            'menu' => [1, 2, 3, 4],
        ]);
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }
}
