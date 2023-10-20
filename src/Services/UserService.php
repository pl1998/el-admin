<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserService
{
    use Permission;

    public function list(array $params): array
    {
        $query = $this->getUserModel()
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
        });
    }

    /**
     * @throws Throwable
     */
    public function update(array $params): void
    {
        DB::connection(config('el_admin.database.connection'))->transaction(function () use ($params) {
            $date = now()->toDateTimeString();

            $userId = $params['id'];
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
        });
    }
}
