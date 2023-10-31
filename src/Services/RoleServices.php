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

namespace Latent\ElAdmin\Services;

use Illuminate\Support\Facades\DB;
use Latent\ElAdmin\Enum\ModelEnum;
use Latent\ElAdmin\Models\MenusCache;
use Latent\ElAdmin\Models\ModelTraits;
use Latent\ElAdmin\Support\Helpers;
use Throwable;

class RoleServices
{
    use ModelTraits;

    /**
     * Get roles list.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function list(array $params): array
    {
        $query = $this->getRoleModel()
            ->with('menus')
            ->when(! empty($params['name']), function ($q) use ($params) {
                $q->where('name', 'like', "{$params['name']}");
            });

        $total = $query->count();
        $list = $query->forPage($params['page'] ?? 1, $params['page_size'])
            ->get()
            ->map(function ($roles) {
                $data = $roles->toArray();
                $data['menus'] = collect($data['menus'])
                    ->where('status', ModelEnum::NORMAL)?->toArray();

                return $data;
            })?->toArray();

        return [
            'list'  => $list,
            'total' => $total,
            'page'  => (int) ($params['page'] ?? 1),
        ];
    }

    /**
     * Create role and to menus.
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
            if (! empty($roleMenus)) {
                $this->getRoleMenusModel()
                    ->insert($roleMenus);
                // 清理缓存
                MenusCache::delMenusCache();
            }
        });
    }

    /**
     * Update role and to menus.
     *
     * @throws Throwable
     */
    public function update(array $params): void
    {
        DB::connection(config('el_admin.database.connection'))->transaction(function () use ($params) {
            $date = now()->toDateTimeString();
            $roleMenus = [];
            $menus = array_values(array_unique($params['menu'] ?? []));
            foreach ($menus as $menuId) {
                $roleMenus[] = [
                    'menu_id' => $menuId,
                    'role_id' => $params['id'],
                    'created_at' => $date,
                    'updated_at' => $date,
                ];
            }
            $save = Helpers::filterNull([
                'status' => $params['status'] ?? null,
                'name' => $params['name'] ?? null,
            ]);
            if (! empty($save)) {
                $this->getRoleModel()
                    ->where('id', $params['id'])
                    ->update($save);
            }

            $model = $this->getRoleMenusModel();

            if (! empty($roleMenus)) {
                $model->where('role_id', $params['id'])->delete();

                $model->insert($roleMenus);
                // 清理缓存
                MenusCache::delMenusCache();
            }
        });
    }

    /**
     * Destroy roles.
     */
    public function destroy(int $id): void
    {
        $this->getRoleModel()->where('id', $id)->delete();
    }

    /**
     * Get all roles.
     */
    public function getAllRole(): ?array
    {
        return $this->getRoleModel()
            ->where('status', ModelEnum::NORMAL)
            ->get(['id', 'name'])
            ?->toArray();
    }
}
