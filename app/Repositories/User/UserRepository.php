<?php

namespace App\Repositories\User;

use App\Entities\User\User;
use App\Repositories\Repository;

class UserRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(User::class);
    }

    /**
     * [控端] 列表清單
     *
     * @param  array   $params
     * @return mixed
     */
    public function getAdminList($params)
    {
        $query = User::select(['account', 'name', 'role_id', 'active', 'created_at']);

        if (isset($params['role']) && $params['role'] > 0) {
            $query = $query->where('role_id', $params['role']);
        }
        if (isset($params['active']) && $params['active'] > 0) {
            $query = $query->active($params['active']);
        }
        if (isset($params['account']) && $params['account'] != '') {
            $query = $query->where('user_account', 'LIKE', $params['account'] . '%');
        }

        return $query->orderBy('account', 'ASC')
                     ->paginate(config('custom.admin.paginate'));
    }
}
