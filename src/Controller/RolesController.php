<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Controller;

use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;
use Latent\ElAdmin\Models\GetModelTraits;
use Latent\ElAdmin\Services\Permission;
use Latent\ElAdmin\Services\RoleServices;
use Illuminate\Http\JsonResponse;
use Throwable;

#[Group("用户角色相关", "用户角色相关接口")]
#[Subgroup("Roles", "角色控制器")]
class RolesController extends Controller
{
    use GetModelTraits,Permission;

    /**
     * @param RoleServices $roleServices
     * @return JsonResponse
     */
    #[Authenticated]
    #[UrlParam("name", "string", "角色名称")]
    #[UrlParam("page", "int", "分页页码")]
    #[UrlParam("page_size", "int", "每页条数")]
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
    public function index(RoleServices $roleServices) :JsonResponse
    {
        $params = $this->validator([
            'name' => 'string|min:1,max:20',
            'page' => 'integer',
            'page_size' => 'integer',
        ]);

        return $this->success($roleServices->list($params));

    }


    /**
     * @param RoleServices $roleServices
     * @return JsonResponse
     * @throws Throwable
     */
    #[BodyParam("name", "string", "角色名称")]
    #[BodyParam("menu", "array", "菜单ID数组")]
    #[Authenticated]
    #[Response(<<<JSON
{
    "data": [],
    "message": "success",
    "status": 200
}
JSON)]
    public function store(RoleServices $roleServices) :JsonResponse
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
     * @return JsonResponse
     * @throws Throwable
     */
    #[BodyParam("id", "string", "角色ID")]
    #[BodyParam("name", "string", "角色名称")]
    #[BodyParam("menu", "array", "菜单ID数组")]
    #[Authenticated]
    #[Response(<<<JSON
{
    "data": [],
    "message": "success",
    "status": 200
}
JSON)]
    public function update($id,RoleServices $roleServices) :JsonResponse
    {
        $params = $this->validator([
            'id' =>'required|exists:connection.'.config('el_admin.database.connection').','.config('el_admin.database.roles_table').',id',
            'name' => 'required|string|min:1,max:20',
            'menu' => 'required|array'
        ],array_merge(request()->post(),['id' => $id]));

        $roleServices->update($params);

        return $this->success();

    }

    /**
     * @param $id
     * @return JsonResponse
     */
    #[BodyParam("id", "string", "角色ID")]
    #[Authenticated]
    #[Response(<<<JSON
{
    "data": [],
    "message": "success",
    "status": 200
}
JSON)]
    public function destroy($id) :JsonResponse
    {
        $this->getRoleModel()->where('id',$id)->delete();
        return $this->success();
    }

}
