<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Controller;

use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;
use Latent\ElAdmin\Models\GetModelTraits;
use Latent\ElAdmin\Services\Permission;
use Latent\ElAdmin\Services\RoleServices;

#[Group("用户角色相关", "用户角色相关接口")]
#[Subgroup("Roles", "角色控制器")]
class RolesController extends Controller
{
    use GetModelTraits,Permission;

    public function index()
    {

    }


    /**
     * @param RoleServices $roleServices
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    #[BodyParam("name", "string", "角色名称")]
    #[BodyParam("menu", "array", "菜单ID数组")]
    #[Response(<<<JSON
{
    "data": [],
    "message": "success",
    "status": 200
}
JSON)]
    public function store(RoleServices $roleServices)
    {
        $params = $this->validator([
            'name' => 'required|string|min:1,max:20',
            'menu' => 'required|array'
        ]);

        $roleServices->add($params);

        return $this->success();
    }

    /**
     * @param RoleServices $roleServices
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    #[BodyParam("id", "string", "角色ID")]
    #[BodyParam("name", "string", "角色名称")]
    #[BodyParam("menu", "array", "菜单ID数组")]
    #[Response(<<<JSON
{
    "data": [],
    "message": "success",
    "status": 200
}
JSON)]
    public function update(RoleServices $roleServices)
    {
        $params = $this->validator([
            'id' =>'required|exists:connection.'.config('el_admin.database.connection').','.config('el_admin.database.roles_table').',id',
            'name' => 'required|string|min:1,max:20',
            'menu' => 'required|array'
        ]);

        $roleServices->update($params);

        return $this->success();

    }

    /**
     * @param RoleServices $roleServices
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    #[UrlParam("id", "string", "角色ID")]
    #[Response(<<<JSON
{
    "data": [],
    "message": "success",
    "status": 200
}
JSON)]
    public function delete($id)
    {
        $this->getRoleModel()->where('id',$id)->delete();
        return $this->success();
    }

}
