<?php

declare(strict_types=1);


namespace Latent\ElAdmin;

use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class AuthTest extends TestCase
{
    use TestConfig;


    public function testAuthMe()
    {

        $token = $this->getToken();
        $data =  $this->curlPost('/me',[],$token);
        if(!empty($data['status']) && $data['status'] == 200) {
            echo "Obtaining user information succeeded. Procedure\n";
            echo json_encode($data,JSON_UNESCAPED_UNICODE)."\n";
        }else{
            $this->expectException(InvalidArgumentException::class);
            $this->expectExceptionMessage('Invalid type value(base/all):');
            throw new \Exception($data['message']."params :".json_encode($this->loginForms,JSON_UNESCAPED_UNICODE));
        }
    }

}
