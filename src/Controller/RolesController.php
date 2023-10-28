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
use Latent\ElAdmin\Models\ModelTraits;
use Latent\ElAdmin\Services\Permission;
use Latent\ElAdmin\Services\RoleServices;

class RolesController extends Controller
{
    use ModelTraits;
    use Permission;

    public function index(RoleServices $roleServices): JsonResponse
    {
        $params = $this->validator([
            'name' => 'string|min:1,max:20',
            'page' => 'integer',
            'page_size' => 'integer',
        ]);

        return $this->success($roleServices->list($params));
    }

    public function store(RoleServices $roleServices): JsonResponse
    {
        $params = $this->validator([
            'name' => 'required|string|min:1,max:20',
            'menu' => 'required|array',
        ]);

        $roleServices->add($params);

        return $this->success();
    }

    public function update($id, RoleServices $roleServices): JsonResponse
    {
        $params = $this->validator([
            'id' => 'required|'.$this->getTableRules('exists', 'roles_table'),
            'name' => 'string|min:1,max:20',
            'menu' => 'array',
            'status' => 'int:0,1',
        ], array_merge(request()->input(), ['id' => $id]));

        $roleServices->update($params);

        return $this->success();
    }

    public function destroy($id, RoleServices $roleServices): JsonResponse
    {
        $roleServices->destroy((int) $id);

        return $this->success();
    }

    public function getAllRole(RoleServices $roleServices): JsonResponse
    {
        return $this->success($roleServices->getAllRole());
    }
}
