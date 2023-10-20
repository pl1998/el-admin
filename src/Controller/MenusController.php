<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Controller;

use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\UrlParam;
use Latent\ElAdmin\Services\MenuServices;
use Latent\ElAdmin\Services\Permission;
use Illuminate\Http\JsonResponse;
use Latent\ElAdmin\Support\Helpers;

class MenusController extends Controller
{
    use Permission;

    #[Authenticated]
    #[UrlParam('id', 'int', '角色ID')]
    #[UrlParam('type', 'int', '类型 0.菜单 1.api')]
    #[UrlParam('hidden', 'int', '类型 0.正常 1.隐藏')]
    #[UrlParam('parent_id', 'int', '父级id')]
    #[UrlParam('page', 'int', '页码 默认1')]
    #[UrlParam('page_size', 'int', '每页条数 默认20')]
    #[Response(<<<JSON
{
    "data": {
       "list":[],
       "page": 1,
       "total": 0
    },
    "message": "success",
    "status": 200
}
JSON)]
    public function index(MenuServices $menuServices): JsonResponse
    {
        $params = $this->validator([
            'name' => 'string',
            'type' => 'int|in:0,1',
            'hidden' => 'int',
            'parent_id' => 'int',
            'page' => 'int',
            'page_size' => 'int',
        ]);

        return $this->success($menuServices->list($params));
    }

    public function store(MenuServices $menuServices)
    {
        $params = $this->validator([
            'name' => 'required|string',
            'sort' => 'required|int',
            'parent_id' => 'required|int',
            'route_path' => 'required|string',
            'type' => 'int|in:0,1',
            'hidden' => 'int|in:0,1',
            'component' => 'exclude_if:type,1|string',
            'route_name' => 'required|exclude_if:type,1|string',
            'icon' => 'required|exclude_if:type,1|string',
        ]);

        $menuServices->add($params);

        return $this->success();
    }

    /**
     * @return JsonResponse
     */
    public function update($id, MenuServices $menuServices)
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

    /**
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->getMenusModel()
            ->where('id', $id)->delete();

        return $this->success();
    }

    /**
     * Get role menus.
     */
    #[Authenticated]
    #[UrlParam('id', 'int', '角色ID')]
    #[Response(<<<JSON
{
    "data": [],
    "message": "success",
    "status": 200
}
JSON)]
    public function getRoleMenu(): JsonResponse
    {
        $params = $this->validator(['id' => 'required|int']);

        return $this->success($this->getRoleMenus($params));
    }


    /**
     * @return JsonResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    #[Authenticated]
    public function getRouteList()
    {
        return $this->success(Helpers::getTree(
            $this->getUserRoutes()
        ));
    }
}
