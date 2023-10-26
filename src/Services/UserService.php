<?php

declare(strict_types=1);

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
            ->when(!empty($params['name']), function ($q) use ($params) {
                $q->where('name', 'like', "{$params['name']}");
            })
            ->when(!empty($params['email']), function ($q) use ($params) {
                $q->where('email', 'like', "{$params['email']}");
            });

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
            'total' => $query->count(),
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
            if (!empty($params['role'])) {
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
                'password' => $params['password'] ? Hash::make($params['password']) : null,
            ]);

            !empty($save) && $this->getUserModel()->where('id', $userId)->update($save);

            if (!empty($params['role'])) {
                $userRoles = [];
                foreach ($params['role'] as $roleId) {
                    $userRoles[] = [
                        'user_id' => $userId,
                        'role_id' => $roleId,
                        'created_at' => $date,
                        'updated_at' => $date,
                    ];
                }
                $model = $this->getUserRolesModel();
                $model->where('user_id', $userId)->delete();
                $this->getUserRolesModel()
                    ->insert($userRoles);
            }
        });
    }
}
