<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Support;


class Helpers
{
    /**
     * @param $list
     * @param string $pk
     * @param string $pid
     * @param string|array|null $child
     * @param int $root
     * @return array
     */
    public static function getTree($list, string $pk = 'id', string $pid = 'parent_id', string|array|null $child = 'children', int $root = 0 ,array $allPid = []): array
    {
        $tree = [];
        if (empty($list)) {
            return $tree;
        }
        if($root ==0) {
            $allPid = array_column($list,'id');
        }
        foreach ($list as $key => $val) {
            if(!in_array($val[$pid],$allPid) && $val[$pid]!=0 && $root == 0){
                $tree[] = $val;
            }
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

    public static function filterNull(array $map): array
    {
        return array_filter($map, function ($val) {
            return !is_null($val);
        });
    }

    public static function filterParams($params, $keys = []): array
    {
        if (empty($params) || !is_array($params)) {
            return [];
        }

        return array_filter($params, function ($key) use ($keys) {
            return !in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @return array
     */
    public static function getKeyValue(array $params, array $keys)
    {
        foreach ($params as &$param) {
            foreach ($param as $key => $value) {
                if (!in_array($key, $keys)) {
                    unset($param[$key]);
                }
            }
        }

        return $params;
    }
}
