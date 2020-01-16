<?php

namespace App\Repositories\Member;

use App\Entities\Member\Member;
use App\Repositories\Repository;

class MemberRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Member::class);
    }

    /**
     * 尋找某平台的會員(帳號)
     *
     * @param  integer $platformId
     * @param  string  $account
     * @param  array   $field
     * @return mixed
     */
    public function findByAccount($platformId, $account, $field = ['id'])
    {
        return Member::select($field)->platform($platformId)
                                     ->where('account', $account)
                                     ->first();
    }

    /**
     * [控端] 列表清單
     *
     * @param  array   $params
     * @return mixed
     */
    public function getAdminList($params)
    {
        $query = Member::select(['platform_id', 'account', 'name', 'credit', 'today_deposit', 'interest', 'active']);

        if (isset($params['platform']) && $params['platform'] > 0) {
            $query = $query->platform($params['platform']);
        }

        if (isset($params['status']) && $params['status'] > 0) {
            $query = $query->active($params['status']);
        }

        if (isset($params['account']) && $params['account'] != '') {
            $query = $query->where('account', 'LIKE', $params['account'] . '%');
        }

        return $query->orderBy('platform_id', 'ASC')
                     ->orderBy('account', 'ASC')
                     ->paginate(config('custom.admin.paginate'));
    }

    /**
     * [排程] 取得要進行結算的會員清單
     *
     * @return mixed
     */
    public function getCronListForSettlementInterest()
    {
        return Member::select(['id', 'platform_id', 'today_deposit', 'credit', 'interest', 'last_transfer_at'])
                     ->where('today_deposit', '>', 0)
                     ->get();
    }
}
