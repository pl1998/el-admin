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

use Exception;

class MenusTest extends TestCase
{
    use TestConfig;

    /**
     * @return void
     *
     * @throws Exception
     */
    public function testGetRouteList(): void
    {
        $token = $this->getToken();
        $this->withHeader('Authorization', "Bearer $token")->get('/getRouteList', [
            'type' => 1,
            'route' => 1,
        ]);
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function testGetAllMenus(): void
    {
        $token = $this->getToken();
        $this->withHeader('Authorization', "Bearer $token")->get('/getAllMenus');
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function testGetAllRole(): void
    {
        $token = $this->getToken();
        $this->withHeader('Authorization', "Bearer $token")->get('/getAllRole');
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function testRoleMenus(): void
    {
        $token = $this->getToken();
        $this->withHeader('Authorization', "Bearer $token")->get('/roleMenus', ['id' =>1]);
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function testMenusUpdate(): void
    {
        $token = $this->getToken();
        $this->withHeader('Authorization', "Bearer $token")->put('/menu/1', [
            'id' =>1,
            'parent_id' => 0,
            'name' => '更新'.mt_rand(1, 9999999),
            'route_path' => '/',
            'sort'=>10,
            'hidden'=>1,
            'type'=>0,
            'method'=>1,
        ]);
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function testMenusStore(): void
    {
        $token = $this->getToken();
        $this->withHeader('Authorization', "Bearer $token")->post('/menu', [
            'parent_id' => 1,
            'name' => '更新'.mt_rand(1, 9999999),
            'route_path' => '/',
            'sort'=>10,
            'hidden'=>1,
            'type'=>0,
            'method'=>1,
        ]);
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }
}
