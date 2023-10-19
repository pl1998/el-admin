<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Support;
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
            $config = config('config.el_admin');
            if(empty($config)) {
                $config =  require __DIR__.'/../config/el_admin.php';
            }
            if(empty($path)) {
                return  $config;
            }
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

    /**
     * Get the infinity tree
     * @param $list
     * @param string $pk
     * @param string $pid
     * @param string|array|null $child
     * @param int $root
     * @return array
     */
    public static  function getTree($list, string $pk = 'id', string $pid = 'parent_id', string|array|null $child = 'children', int $root = 0): array
    {
        $tree = [];
        if(empty($list)) return $tree;
        foreach ($list as $key => $val) {
            if ($val[$pid] === $root) {
                unset($list[$key]);
                if (!empty($list)) {
                    $child = self::getTree($list, $pk, $pid, $child, $val[$pk]);
                    if (!empty($child)) {
                        $val['children'] = $child;
                    }
                }
                $tree[] = $val;
            }
        }
        return $tree;
    }


    /**
     * @param array $map
     * @return array
     */
    public static function filterNull(array $map) :array
    {
        return array_filter($map,function ($val){
           return !is_null($val);
        });
    }


    /**
     *
     * @param $params
     * @param $keys
     * @return array
     */
    public static function filterParams($params,$keys=[]) :array
    {
        if(empty($params) || !is_array($params)) {
            return [];
        }
        return array_filter($params,function ($key) use ($keys) {
            return !in_array($key,$keys);
        },ARRAY_FILTER_USE_KEY);
    }
}
