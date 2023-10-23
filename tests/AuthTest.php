<?php

declare(strict_types=1);

namespace Latent\ElAdmin;

use Tests\TestCase;

class AuthTest extends TestCase
{
    use TestConfig;

    /**
     * @return void
     *
     * @throws \Exception
     */
    public function testAuthMe()
    {
        $this->getToken();
    }
}
