<?php

namespace App\Repositories\User;

use App\Entities\User\UserOperation;
use App\Repositories\Repository;

class UserOperationRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(UserOperation::class);
    }

    /**
     * [控端] 列表清單
     *
     * @param  array   $params
     * @return mixed
     */
    public function getAdminList($params)
    {
        $query = UserOperation::select(['created_at', 'user_account', 'user_name', 'ip', 'func_key',  'type', 'targets', 'content'])
                        ->whereBetween('created_at', [$params['start'], $params['end']]);

        if (isset($params['func']) && $params['func'] > 0) {
            $query = $query->where('func_key', $params['func']);
        }

        if (isset($params['user']) && $params['user'] > 0) {
            $query = $query->where('user_id', $params['user']);
        }
        return $query->orderBy('created_at', 'DESC')
                     ->paginate(config('custom.admin.paginate'));
    }

    /**
     * [控端] 取得單筆資料的異動紀錄
     *
     * @param  integer  $funcKey
     * @param  integer  $funcId
     * @return mixed
     */
    public function getAdminSingleList($funcKey, $funcId)
    {
        return UserOperation::select(['created_at', 'user_account', 'user_name', 'ip',  'type', 'targets', 'content'])
                            ->where('func_key', $funcKey)
                            ->where('func_id', $funcId)
                            ->orderBy('created_at', 'DESC')
                            ->paginate(config('custom.admin.paginate'));
    }
}
