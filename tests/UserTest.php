<?php

declare(strict_types=1);

namespace Latent\ElAdmin;

use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class UserTest extends TestCase
{
    use TestConfig;

    public function testUserList()
    {
        $token = $this->getToken();
    }

    /**
     * @return void
     *
     * @throws \Exception
     */
    public function testUserStore()
    {
        $token = $this->getToken();

        try {
            $data = $this->curlPost('/user', [
                'email' => time().'test@qq.com',
                'name' => time().'demo',
                'password' => 'demo123',
                'repeated_password' => 'demo123',
            ], $token);
            if (!empty($data['status']) && 200 == $data['status']) {
                echo "testUserStore Obtaining user information succeeded. Procedure\n";
                echo json_encode($data, JSON_UNESCAPED_UNICODE)."\n";
            } else {
                var_dump($data);
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage('Invalid type value(base/all):');
                throw new \Exception($data['message'].'params :'.json_encode($this->loginForms, JSON_UNESCAPED_UNICODE));
            }
        } catch (\Exception $e) {
            $this->expectException(InvalidArgumentException::class);
            $this->expectExceptionMessage('Invalid type value(base/all):');
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return void
     *
     * @throws \Exception
     */
    public function testUserUpdate()
    {
        $token = $this->getToken();

        try {
            $data = $this->curlPost('/user/3', [
                'email' => 'test@qq.com',
                'name' => 'demo222',
                'password' => 'demo12322',
                'repeated_password' => '123456',
            ], $token, 'PUT');
            if (!empty($data['status']) && 200 == $data['status']) {
                echo "testUserUpdate Obtaining user information succeeded. Procedure\n";
                echo json_encode($data, JSON_UNESCAPED_UNICODE)."\n";
            } else {
                var_dump($data);
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage('Invalid type value(base/all):');
                throw new \Exception($data['message'].'params :'.json_encode($this->loginForms, JSON_UNESCAPED_UNICODE));
            }
        } catch (\Exception $e) {
            $this->expectException(InvalidArgumentException::class);
            $this->expectExceptionMessage('Invalid type value(base/all):');
            throw new \Exception($e->getMessage());
        }
    }
}
