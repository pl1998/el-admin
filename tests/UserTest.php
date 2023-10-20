<?php

declare(strict_types=1);

namespace Latent\ElAdmin;

use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class UserTest extends TestCase
{
   use TestConfig;

//    public function testUserList()
//    {
//
//
//    }

    public function testUserStore()
    {
        $token = $this->getToken();

        try {
            $data =  $this->curlPost('/user',[
                'email' => 'xxx',
                'name'  => 'demo'
            ],$token);
            if(!empty($data['status']) && $data['status'] == 200) {

                echo "Obtaining user information succeeded. Procedure\n";
                echo json_encode($data,JSON_UNESCAPED_UNICODE)."\n";
            }else{
                var_dump($data);
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage('Invalid type value(base/all):');
                throw new \Exception($data['message']."params :".json_encode($this->loginForms,JSON_UNESCAPED_UNICODE));
            }
        }catch (\Exception $e) {
            $this->expectException(InvalidArgumentException::class);
            $this->expectExceptionMessage('Invalid type value(base/all):');
            throw new \Exception($e->getMessage());
        }

    }


}
