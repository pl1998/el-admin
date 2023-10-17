<?php

declare(strict_types=1);


namespace ElAdmin\LaravelVueAdmin;
use Exception;

class Helpers
{
    /**
     * @param string $path
     * @return mixed|string
     */
    public static function ElConfig(string $path = ''): mixed
    {
        try {
            $config =  require __DIR__.'/../config/el_admin.php';

            $data = explode('.',$path);

            foreach ($data as $value) {
                if(!isset($config[$value])){
                    return "";
                }
                $config = $config[$value];
            }
            return $config;

        }catch (Exception) {
            return "";
        }
    }
}
