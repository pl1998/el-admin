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

trait TestConfig
{
    /**
     * login form.
     *
     * @var string[]
     */
    public array $loginForms = [
        'email' => 'admin@gmail.com',
        'password' => '123456',
    ];

    /** @var string */
    public string|null $access_token;

    /**
     * @throws Exception
     */
    public function getToken(): mixed
    {
        $this->post('/login', $this->loginForms);
        $this->assertJson($this->response);
        $this->assertStatus(200);
        $this->access_token = $this->json()['data']['access_token'] ?? '';
        $this->assertNotEmpty($this->access_token);

        return  $this->access_token;
    }

    /**
     * @param  int  $httpCode
     * @return void
     *
     * @throws Exception
     */
    public function assertStatus(int $httpCode): void
    {
        if ($this->httpCode != $httpCode) {
            var_dump($this->response);
            throw new Exception('http响应码结果为：'.$httpCode);
        }
    }
}
