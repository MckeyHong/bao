<?php

namespace App\Repositories\User;

use App\Entities\User\UserLogin;
use App\Repositories\Repository;

class UserLoginRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(UserLogin::class);
    }

    /**
     * [控端] 登入日誌列表清單
     *
     * @param  array   $params
     * @return mixed
     */
    public function getAdminList($params)
    {
        $query = UserLogin::select(['*'])
                        ->whereBetween('created_at', [$params['start'], $params['end']]);

        if (isset($params['status']) && $params['status'] > 0) {
            $query = $query->status($params['status']);
        }

        if (isset($params['account']) && $params['account'] != '') {
            $query = $query->where('user_account', 'LIKE', $params['account'] . '%');
        }

        return $query->orderBy('created_at', 'DESC')
                     ->paginate(config('custom.admin.paginate'));
    }
}
