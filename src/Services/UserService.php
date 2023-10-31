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
use Illuminate\Support\Facades\Hash;
use Latent\ElAdmin\Enum\ModelEnum;
use Latent\ElAdmin\Support\Helpers;
use Throwable;

class UserService
{
    use Permission;

    /**
     * Get User List.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function list(array $params): array
    {
        $query = $this->getUserModel()
            ->with('roles')
            ->when(! empty($params['name']), function ($q) use ($params) {
                $q->where('name', 'like', "%{$params['name']}%");
            })
            ->when(! empty($params['email']), function ($q) use ($params) {
                $q->where('email', 'like', "%{$params['email']}%");
            });

        $total = $query->count();
        $list = $query
            ->forPage($params['page'] ?? 1, $params['page_size'] ?? 10)
            ->get()
            ->map(function ($user) {
                $data = $user->toArray();
                $data['roles'] = Helpers::getKeyValue(
                    collect($data['roles'])
                        ->where('status', ModelEnum::NORMAL)?->toArray(), ['id', 'name']);

                return $data;
            })?->toArray();

        return [
            'list' => $list,
            'total' => $total,
            'page' => (int) ($params['page'] ?? 1),
        ];
    }

    /**
     * Add user.
     *
     * @throws Throwable
     */
    public function add(array $params): void
    {
        DB::connection(config('el_admin.database.connection'))->transaction(function () use ($params) {
            $date = now()->toDateTimeString();

            $userId = $this->getUserModel()->insertGetId([
                'name' => $params['name'],
                'password' => Hash::make($params['password']),
                'email' => $params['email'],
                'created_at' => $date,
                'updated_at' => $date,
            ]);
            $userRoles = [];
            if (! empty($params['role'])) {
                foreach ($params['role'] as $roleId) {
                    $userRoles[] = [
                        'user_id' => $userId,
                        'role_id' => $roleId,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ];
                }
                $this->getUserRolesModel()
                    ->insert($userRoles);
            }
        });
    }

    /**
     * Update user info.
     *
     * @throws Throwable
     */
    public function update(array $params): void
    {
        DB::connection(config('el_admin.database.connection'))->transaction(function () use ($params) {
            $date = now()->toDateTimeString();

            $userId = $params['id'];

            $save = Helpers::filterNull([
                'name' => $params['name'] ?? null,
                'email' => $params['email'] ?? null,
                'password' => ! empty($params['password']) ? Hash::make($params['password']) : null,
                'status' => $params['status'] ?? null,
            ]);

            ! empty($save) && $this->getUserModel()
                ->where('id', $userId)
                ->update($save);

            $roles = $params['role'] ?? [];

            // Filter out non-integer values
            // Note: This is a temporary fix due to the frontend sending role array: [{}，1， 2].
            // TODO: Remove this block once the frontend is fixed.
            $roles = array_filter($roles, function ($value) {
                return is_int($value);
            });

            // Remove duplicate values
            // Note: This is a temporary fix due to the frontend sendind duplicated roleIds: [2，2, 2].
            $roles = array_values(array_unique($roles));

            if (! empty($roles)) {
                $userRoles = [];
                foreach ($roles as $roleId) {
                    $userRoles[] = [
                        'user_id' => $userId,
                        'role_id' => $roleId,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ];
                }
                $model = $this->getUserRolesModel();
                // Due to the soft delete duplicate records not being deleted,
                $model->where('user_id', $userId)->forceDelete();
                $this->getUserRolesModel()
                    ->insert($userRoles);
            }
        });
    }

    /**
     * Destroy users.
     */
    public function destroy(int $id): void
    {
        $this->getUserModel()->where('id', $id)->delete();
    }
}
