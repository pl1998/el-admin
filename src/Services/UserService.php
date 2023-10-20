<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Latent\ElAdmin\Support\Helpers;
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
            if(!empty($params['role'])) {
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
     *
     * @param array $params
     * @return void
     * @throws Throwable
     */
    public function update(array $params): void
    {
        DB::connection(config('el_admin.database.connection'))->transaction(function () use ($params) {
            $date = now()->toDateTimeString();

            $userId = $params['id'];

            $save = Helpers::filterNull([
                'name'     => $params['name'] ?? null,
                'email'    => $params['email'] ?? null,
                'password' => $params['password'] ? Hash::make($params['password']) : null,
            ]);

            !empty($save) &&   $this->getUserModel()->where('id', $userId)->update($save);

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
