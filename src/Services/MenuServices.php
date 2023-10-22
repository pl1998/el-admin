<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Services;

use Latent\ElAdmin\Enum\ModelEnum;
use Latent\ElAdmin\Support\Helpers;

class MenuServices
{
    use Permission;

    /** @var array request params */
    public array $params = [];

    /**
     * @param array $params
     * @return array
     */
    public function list(array $params): array
    {
        $this->params = $params;
        $query = $this->getMenusModel()
            ->when(!empty($params['name']), function ($q) {
                $q->where('name', 'like', "{$this->params['name']}%")->orWhere('route_name', 'like', "{$this->params['name']}%");
            })
            ->when(!empty($params['type']), function ($q) {
                $q->where('type', "{$this->params['type']}");
            })
            ->when(!empty($params['parent_id']), function ($q) {
                $q->where('parent_id', "{$this->params['parent_id']}");
            })
            ->when(!empty($params['method']), function ($q) {
                $q->where('method', "{$this->params['method']}");
            })
            ->when(!empty($params['hidden']), function ($q) {
                $q->where('hidden', "{$this->params['hidden']}");
            })->orderBy('parent_id')->orderByDesc('sort');

        return [
            'list'  =>Helpers::getTree($query->forPage($params['page'] ?? 1, $params['page_size'] ?? 10)->get()?->toArray()) ,
            'total' => $query->count(),
            'page'  => (int) ($params['page'] ?? 1),
        ];
    }

    /**
     * create menus.
     *
     * @return void
     */
    public function add(array $params)
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

        if($params['type'] == ModelEnum::API) {
            unset($params['component']);
        }
        $this->getMenusModel()->create($create);
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
