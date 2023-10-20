<?php

declare(strict_types=1);


namespace Latent\ElAdmin;

use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

trait TestConfig
{
    public $tests_token_prefix = 'tests:token';
    /** @var string test host */
    public $host = 'http://0.0.0.0:8000/api/v1/el_admin';

    public null|string $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMC4wLjAuMDo4MDAwL2FwaS92MS9lbF9hZG1pbi9sb2dpbiIsImlhdCI6MTY5Nzc3NDkzMCwiZXhwIjoxNjk3OTkwOTMwLCJuYmYiOjE2OTc3NzQ5MzAsImp0aSI6IktERjFOR0hyQU44dGVkeG8iLCJzdWIiOiIxIiwicHJ2IjoiNjcyZjBkZTgwZWE2YzlhOGUyZDVhMTZkNjdjNjY2NjBmOTRkNDI1MiJ9.0_2JuMgO8FARxGH2HP2-s52uJXyU6bIg7RP0W7DIYjk';

    public $loginForms = [
        'email' => 'admin@gmail.com',
        'password' => '123456'
    ];



    public function setToken($data)
    {
        Cache::set($this->tests_token_prefix,$data['access_token'],$data['expires_in']);
    }

    public function getToken()
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
    public function curlPost($url,$data=[],$token='')
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
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$data,
            CURLOPT_HTTPHEADER => array(
                'Authorization:Bearer '.$token,
                'Cookie: Hm_lvt_bh_ud=5FBD65FC75DB4EB1F8C52B2865AC18D6',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response,true);
    }

}
