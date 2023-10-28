<?php

declare(strict_types=1);

/*
 * This file is part of the latent/el-admin.
 *
 * (c) latent<pltrueover@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Latent\ElAdmin\Support;

class Helpers
{
    /**
     * Get tree list.
     */
    public static function getTree($list, string $pk = 'id', string $pid = 'parent_id', string|array|null $child = 'children', int $root = 0, array $allPid = []): array
    {
        $tree = [];
        if (empty($list)) {
            return $tree;
        }
        if (0 == $root) {
            $allPid = array_column($list, 'id');
        }
        foreach ($list as $key => $val) {
            if (! in_array($val[$pid], $allPid) && 0 != $val[$pid] && 0 == $root) {
                $tree[] = $val;
            }
            if ($val[$pid] === $root) {
                unset($list[$key]);
                if (! empty($list)) {
                    $child = self::getTree($list, $pk, $pid, $child, $val[$pk]);
                    if (! empty($child)) {
                        $val['children'] = $child;
                    }
                }
                $tree[] = $val;
            }
        }

        return $tree;
    }

    /**
     * Filter null to array.
     */
    public static function filterNull(array $map): array
    {
        return array_filter($map, function ($val) {
            return ! is_null($val);
        });
    }

    /**
     * Filter array keys.
     */
    public static function filterParams($params, $keys = []): array
    {
        if (empty($params) || ! is_array($params)) {
            return [];
        }

        return array_filter($params, function ($key) use ($keys) {
            return ! in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Get array keys.
     *
     * @return array
     */
    public static function getKeyValue(array $params, array $keys)
    {
        foreach ($params as &$param) {
            foreach ($param as $key => $value) {
                if (! in_array($key, $keys)) {
                    unset($param[$key]);
                }
            }
        }

        return $params;
    }
}
