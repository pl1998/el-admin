<?php

function el_config(string $path = '')
{
    try {
        $config =  require __DIR__.'/../../config/el_admin.php';

        $data = explode('.',$path);
        foreach ($data as $value) {
            if(!isset($config[$value])){
                return "";
            }
            $config = $config[$value];
        }
        return $config;

    }catch (Exception $e) {
        return "";
    }
}
