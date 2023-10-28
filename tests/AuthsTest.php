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

use Exception;

class AuthsTest extends TestCase
{
    use TestConfig;

    /**
     * @return void
     *
     * @throws Exception
     */
    public function testAuthMe(): void
    {
        $this->getToken();
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function testMe(): void
    {
        $token = $this->getToken();
        $this->withHeader('Authorization', "Bearer $token")->post('/me', ['is_menus' => 1]);
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function testLogout(): void
    {
        $token = $this->getToken();
        $this->withHeader('Authorization', "Bearer $token")->post('/logout');
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function testRefresh(): void
    {
        $token = $this->getToken();
        $this->withHeader('Authorization', "Bearer $token")->post('/refresh');
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }
}
