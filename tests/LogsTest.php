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

class LogsTest extends TestCase
{
    use TestConfig;

    /**
     * @return void
     *
     * @throws Exception
     */
    public function testLogIndex(): void
    {
        $token = $this->getToken();
        $this->withHeader('Authorization', "Bearer $token")->get('/log', [
            'ip' => '127.0.0.1',
            'user_id' => 1,
        ]);
        $this->assertStatus($this->httpCode);
        $this->assertStatus($this->json()['status'] ?? 0);
    }
}
