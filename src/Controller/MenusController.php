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

namespace Latent\ElAdmin\Controller;

use Illuminate\Http\JsonResponse;
use Latent\ElAdmin\Exceptions\ValidateException;
use Latent\ElAdmin\Services\MenuServices;
use Latent\ElAdmin\Services\Permission;
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
            'hidden' => 'int|in:0,1',
            'component' => 'nullable',
            'route_name' => 'nullable',
            'icon' => 'nullable',
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
            'sort' => 'int',
            'parent_id' => 'required|int',
            'route_path' => 'required|string',
            'type' => 'int|in:0,1',
            'hidden' => 'int|in:0,1',
            'component' => 'nullable',
            'route_name' => 'nullable',
            'icon' => 'nullable',
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

    public function getAllMenus(MenuServices $menuServices): JsonResponse
    {
        return $this->success($menuServices->getAllMenus());
    }
}
