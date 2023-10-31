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

namespace Latent\ElAdmin\Services;

use Latent\ElAdmin\Enum\ModelEnum;
use Latent\ElAdmin\Support\Helpers;

class MenuServices
{
    use Permission;

    /**
     * Request params.
     */
    public array $params = [];

    /**
     * Menu list.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function list(array $params): array
    {
        $this->params = $params;
        $query = $this->getMenusModel()
            ->when(! empty($params['name']), function ($q) {
                $q->where('name', 'like', "{$this->params['name']}%")->orWhere('route_name', 'like', "{$this->params['name']}%");
            })
            ->when(isset($params['type']), function ($q) {
                $q->where('type', "{$this->params['type']}");
            })
            ->when(isset($params['parent_id']), function ($q) {
                $q->where('parent_id', "{$this->params['parent_id']}");
            })
            ->when(isset($params['method']), function ($q) {
                $q->where('method', "{$this->params['method']}");
            })
            ->when(isset($params['hidden']), function ($q) {
                $q->where('hidden', "{$this->params['hidden']}");
            })->orderBy('parent_id')->orderByDesc('sort');

        $total = $query->count();
        $list = $query->forPage($params['page'] ?? 1, $params['page_size'] ?? 10)->get()?->toArray();

        return [
            'list'  => Helpers::getTree($list),
            'total' => $total,
            'page'  => (int) ($params['page'] ?? 1),
        ];
    }

    /**
     * create menus.
     */
    public function add(array $params): void
    {
        $create = Helpers::filterNull([
            'name' => $params['name'] ?? null,
            'method' => $params['method'] ?? null,
            'sort' => $params['sort'] ?? null,
            'parent_id' => $params['parent_id'] ?? null,
            'route_path' => $params['route_path'] ?? null,
            'type' => $params['type'] ?? null,
            'hidden' => $params['hidden'] ?? null,
            'component' => $params['component'] ?? null,
            'route_name' => $params['route_name'] ?? null,
            'icon' => $params['icon'] ?? null,
        ]);

        if (ModelEnum::API == $params['type']) {
            unset($params['component']);
        }
        $this->getMenusModel()->create($create);
    }

    /**
     * create menus.
     */
    public function update(array $params): void
    {
        $this->getMenusModel()
            ->where('id', $params['id'])
            ->update(Helpers::filterNull([
                'name' => $params['name'] ?? null,
                'sort' => $params['sort'] ?? null,
                'parent_id' => $params['parent_id'] ?? null,
                'route_path' => $params['route_path'] ?? null,
                'type' => $params['type'] ?? null,
                'hidden' => $params['hidden'] ?? null,
                'component' => $params['component'] ?? null,
                'route_name' => $params['route_name'] ?? null,
                'icon' => $params['icon'] ?? null,
            ]));
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getAllMenus(): array
    {
        $list = $this->getMenusModel()->where('hidden', ModelEnum::NORMAL)
            ->get()?->toArray();

        return [
            'ids' => array_column($list, 'id'),
            'list' => Helpers::getTree($list),
        ];
    }
}
