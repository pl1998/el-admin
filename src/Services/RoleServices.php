<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Services;

use Illuminate\Support\Facades\DB;
use Latent\ElAdmin\Models\GetModelTraits;
use Throwable;

class RoleServices
{
    use GetModelTraits;

    /**
     * Get role lists.
     */
    public function list(array $params): array
    {
        $query = $this->getRoleModel()
            ->when(!empty($params['name']), function ($q) use ($params) {
                $q->where('name', 'like', "{$params['name']}");
            });

        return [
            'list' => $query->page($params['page'] ?? 1, $params['page_size'])->get()?->toArray(),
            'total' => $query->count(),
            'page' => (int) ($params['page'] ?? 1),
        ];
    }

    /**
     * create role and to menus.
     *
     * @throws Throwable
     */
    public function add(array $params): void
    {
        DB::connection(config('el_admin.database.connection'))->transaction(function () use ($params) {
            $date = now()->toDateTimeString();

            $roleId = $this->getRoleModel()->insertGetId([
                    'name' => $params['name'],
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            $roleMenus = [];
            foreach ($params['menu'] as $menuId) {
                $roleMenus[] = [
                    'menu_id' => $menuId,
                    'role_id' => $roleId,
                    'created_at' => $date,
                    'updated_at' => $date,
                ];
            }
            $this->getRoleMenusModel()
                ->insert($roleMenus);
        });
    }

    /**
     * update role and to menus.
     *
     * @throws Throwable
     */
    public function update(array $params): void
    {
        DB::connection(config('el_admin.database.connection'))->transaction(function () use ($params) {
            $date = now()->toDateTimeString();

            $roleMenus = [];
            foreach ($params['menu'] as $menuId) {
                $roleMenus[] = [
                    'menu_id' => $menuId,
                    'role_id' => $params['id'],
                    'created_at' => $date,
                    'updated_at' => $date,
                ];
            }
            $model = $this->getRoleMenusModel();

            $model->where('role_id', $params['id'])->delete();

            $model->insert($roleMenus);
        });
    }
}
