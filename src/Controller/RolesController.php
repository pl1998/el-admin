<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Controller;

use Latent\ElAdmin\Enum\ModelEnum;
use Latent\ElAdmin\Exceptions\ValidateException;
use Latent\ElAdmin\Models\GetModelTraits;
use Latent\ElAdmin\Services\Permission;
use Latent\ElAdmin\Services\RoleServices;
use Illuminate\Http\JsonResponse;
use Throwable;

class RolesController extends Controller
{
    use GetModelTraits;
    use Permission;

    /**
     * @throws ValidateException
     */
    public function index(RoleServices $roleServices): JsonResponse
    {
        $params = $this->validator([
            'name' => 'string|min:1,max:20',
            'page' => 'integer',
            'page_size' => 'integer',
        ]);

        return $this->success($roleServices->list($params));
    }

    /**
     * @throws Throwable
     * @throws ValidateException
     */
    public function store(RoleServices $roleServices): JsonResponse
    {
        $params = $this->validator([
            'name' => 'required|string|min:1,max:20',
            'menu' => 'required|array',
        ]);

        $roleServices->add($params);

        return $this->success();
    }

    /**
     * @throws Throwable
     * @throws ValidateException
     */
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

    public function destroy($id): JsonResponse
    {
        $this->getRoleModel()->where('id', $id)->delete();

        return $this->success();
    }

    public function getAllRole(): JsonResponse
    {
        $list = $this->getRoleModel()->where('status', ModelEnum::NORMAL)
            ->get(['id', 'name'])?->toArray();

        return $this->success($list);
    }
}
