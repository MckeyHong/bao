<?php

namespace App\Repositories\Member;

use DB;
use App\Entities\Member\MemberInfoStatDaily;
use App\Repositories\Repository;

class MemberInfoStatDailyRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(MemberInfoStatDaily::class);
    }

    /**
     * 取得會員指定日期的資訊
     *
     * @param  integer $memberId
     * @param  string  $betAt
     * @param  array   $field
     * @return mixed
     */
    public function findByMemberIdAndBetAt($memberId, $betAt, $field = ['bet_total', 'deposit_credit'])
    {
        return MemberInfoStatDaily::select($field)
                                  ->member($memberId)
                                  ->where('bet_at', $betAt)
                                  ->first();
    }

    /**
     * [控端] 利息報表 - 總表
     *
     * @param  array  $params
     * @return mixed
     */
    public function getAdminSummaryList($params)
    {
        $query = MemberInfoStatDaily::selectRaw('platform_id, SUM(deposit_credit) AS deposit_credit, SUM(transfer_interest) AS transfer_interest')
                                    ->whereBetween('bet_at', [$params['start'], $params['end']]);

        if (isset($params['platform']) && $params['platform'] > 0) {
            $query = $query->platform($params['platform']);
        }
        return $query->groupBy('platform_id')->get();
    }

    /**
     * [會員端] 更新儲值/提領時相關資訊
     *
     * @param  integer  $memberId
     * @param  string   $betAt
     * @param  integer  $credit
     * @param  integer  $interest
     * @param  string   $symbol
     * @return mixed
     */
    public function updateByWeb($memberId, $betAt, $credit = 0, $interest = 0, $symbol = '+')
    {
        return MemberInfoStatDaily::member($memberId)
                                  ->where('bet_at', $betAt)
                                  ->update([
                                      'deposit_credit' => DB::raw('deposit_credit ' . $symbol . $credit),
                                      'interest'       => DB::raw('interest + ' . $interest),
                                  ]);
    }
}
