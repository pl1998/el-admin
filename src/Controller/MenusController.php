<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Controller;

use Latent\ElAdmin\Enum\ModelEnum;
use Latent\ElAdmin\Exceptions\ValidateException;
use Latent\ElAdmin\Services\MenuServices;
use Latent\ElAdmin\Services\Permission;
use Illuminate\Http\JsonResponse;
use Latent\ElAdmin\Support\Helpers;
use Psr\SimpleCache\InvalidArgumentException;

class MenusController extends Controller
{
    use Permission;

    /**
     * @throws ValidateException
     */
    public function index(MenuServices $menuServices): JsonResponse
    {
        $params = $this->validator([
            'name' => 'string',
            'type' => 'int|in:0,1',
            'hidden' => 'int',
            'parent_id' => 'int',
            'page' => 'int',
            'method' => 'int',
            'page_size' => 'int',
        ]);

        return $this->success($menuServices->list($params));
    }

    /**
     * @throws ValidateException
     */
    public function store(MenuServices $menuServices): JsonResponse
    {
        $params = $this->validator([
            'name' => 'required|string|max:30',
            'sort' => 'required|int',
            'parent_id' => 'required|int',
            'route_path' => 'required|string',
            'type' => 'int|in:0,1',
            'method' => 'required|int|in:0,1,2,3,4,5,6',
            'hidden' => 'boolean',
            'component' => 'string',
            'route_name' => 'nullable',
            'icon' => 'string',
        ]);

        $menuServices->add($params);

        return $this->success();
    }

    /**
     * @throws ValidateException
     */
    public function update($id, MenuServices $menuServices): JsonResponse
    {
        $params = $this->validator([
            'id' => 'required|int',
            'name' => 'required|string',
            'sort' => 'required|int',
            'parent_id' => 'required|int',
            'route_path' => 'required|string',
            'type' => 'int|in:0,1',
            'hidden' => 'int|in:0,1',
            'component' => 'exclude_if:type,1|string',
            'route_name' => 'required|exclude_if:type,1|string',
            'icon' => 'required|exclude_if:type,1|string',
        ], array_merge(request()->post(), ['id' => $id]));

        $menuServices->update($params);

        return $this->success();
    }

    public function destroy($id): JsonResponse
    {
        $this->getMenusModel()
            ->where('id', $id)->delete();

        return $this->success();
    }

    /**
     * @throws ValidateException
     */
    public function getRoleMenu(): JsonResponse
    {
        $params = $this->validator(['id' => 'required|int']);

        return $this->success($this->getRoleMenus($params));
    }

    /**
     * @throws ValidateException
     * @throws InvalidArgumentException
     */
    public function getRouteList(): JsonResponse
    {
        $params = $this->validator([
            'type' => 'int|in:0,1',
            'route' => 'int|in:0,1,2',
        ]);

        return $this->success(Helpers::getTree(
            $this->getUserRoutes($params)
        ));
    }

    public function getAllMenus(): JsonResponse
    {
        $list = $this->getMenusModel()->where('hidden', ModelEnum::NORMAL)
            ->get()?->toArray();

        return $this->success([
            'ids' => array_column($list, 'id'),
            'list' => Helpers::getTree($list),
        ]);
    }
}
