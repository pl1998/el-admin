<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Services;

use Latent\ElAdmin\Support\Helpers;

class MenuServices
{
    use Permission;

    /** @var array request params */
    protected array $params = [];

    public function list(array $params): array
    {
        $query = $this->getMenusModel()
            ->when(!empty($params['name']), function ($q) {
                $q->where('name', 'like', "{$this->params['name']}")
                    ->orWhere('route_name', 'like', "{$this->params['name']}");
            })
            ->when(!empty($params['type']), function ($q) {
                $q->where('type', "{$this->params['type']}");
            })
            ->when(!empty($params['parent_id']), function ($q) {
                $q->where('parent_id', "{$this->params['parent_id']}");
            })
            ->when(!empty($params['hidden']), function ($q) {
                $q->where('hidden', "{$this->params['hidden']}");
            })->orderDesc('sort');

        return [
            'list' => $query->page($params['page'] ?? 1, $params['page_size'])->get()?->toArray(),
            'total' => $query->count(),
            'page' => (int) ($params['page'] ?? 1),
        ];
    }

    /**
     * create menus.
     *
     * @return void
     */
    public function add(array $params)
    {
        $this->getMenusModel()->create(Helpers::filterNull([
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
     * create menus.
     *
     * @return void
     */
    public function update(array $params)
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
}
