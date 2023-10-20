<?php

declare(strict_types=1);


namespace Latent\ElAdmin;

use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

trait TestConfig
{
    /** @var string test host */
    public $host = 'http://0.0.0.0:8000/api/v1/el_admin';
    /**
     * login form
     * @var string[]
     */
    public $loginForms = [
        'email' => 'admin@gmail.com',
        'password' => '123456'
    ];

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getToken() :mixed
    {
        $data = $this->curlPost('/login',$this->loginForms);
        if($data['status'] == 200) {
            return $data['access_token'];
        }else{
            $this->expectException(InvalidArgumentException::class);
            $this->expectExceptionMessage('Invalid type value(base/all):');
            throw new \Exception($data['message']."params :".json_encode($this->loginForms,JSON_UNESCAPED_UNICODE));
        }
    }
    /**
     * @param $url
     * @param $data
     * @return mixed
     */
    public function curlPost($url,$data=[],$token='',$method='POST') :mixed
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->host.$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS =>$data,
            CURLOPT_HTTPHEADER => array(
                'Authorization:Bearer '.$token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response,true);
    }

}
