<?php

declare(strict_types=1);

namespace Latent\ElAdmin;

use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

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
        $token = $this->getToken();
        $data = $this->curlPost('/me', [], $token);
        if (!empty($data['status']) && 200 == $data['status']) {
            echo "Obtaining user information succeeded. Procedure\n";
            echo json_encode($data, JSON_UNESCAPED_UNICODE)."\n";
        } else {
            $this->expectException(InvalidArgumentException::class);
            $this->expectExceptionMessage('Invalid type value(base/all):');
            throw new \Exception($data['message'].'params :'.json_encode($this->loginForms, JSON_UNESCAPED_UNICODE));
        }
    }
}
