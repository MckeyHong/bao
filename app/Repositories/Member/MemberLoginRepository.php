<?php

namespace App\Repositories\Member;

use App\Entities\Member\MemberLogin;
use App\Repositories\Repository;

class MemberLoginRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(MemberLogin::class);
    }

    /**
     * [控端] 列表清單
     *
     * @param  array   $params
     * @return mixed
     */
    public function getAdminList($params)
    {
        $query = MemberLogin::select(['created_at', 'platform_id', 'member_account', 'member_name', 'login_ip', 'area', 'device', 'device_info'])
                        ->whereBetween('created_at', [$params['start'], $params['end']]);

        if (isset($params['status']) && $params['status'] > 0) {
            $query = $query->status($params['status']);
        }

        if (isset($params['platform']) && $params['platform'] > 0) {
            $query = $query->platform($params['platform']);
        }

        if (isset($params['account']) && $params['account'] != '') {
            $query = $query->where('member_account', 'LIKE', $params['account'] . '%');
        }

        return $query->orderBy('created_at', 'DESC')->paginate(config('custom.admin.paginate'));
    }
}
