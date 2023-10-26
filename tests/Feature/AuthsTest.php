<?php

declare(strict_types=1);

namespace Latent\ElAdmin\tests\Feature;

use Latent\ElAdmin\TestConfig;
use Tests\TestCase;

class AuthsTest extends TestCase
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
