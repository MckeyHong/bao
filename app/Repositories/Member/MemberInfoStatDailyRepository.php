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
     * [控端] 會員報表 - 總表
     *
     * @param  array  $params
     * @return mixed
     */
    public function getAdminSummaryByMember($params)
    {
        return MemberInfoStatDaily::selectRaw('member_info_stat_daily.bet_at AS bet_at, SUM(member_info_stat_daily.deposit_credit) AS deposit_credit, SUM(member_info_stat_daily.interest) AS interest')
                                  ->leftjoin('members', 'members.id', '=', 'member_info_stat_daily.member_id')
                                  ->whereBetween('member_info_stat_daily.bet_at', [$params['start'], $params['end']])
                                  ->where('member_info_stat_daily.member_id', $params['platform'])
                                  ->where('members.account', $params['account'])
                                  ->groupBy('member_info_stat_daily.bet_at')
                                  ->orderBy('member_info_stat_daily.bet_at', 'DESC')
                                  ->get();
    }

    /**
     * [控端] 利息報表 - 總表
     *
     * @param  array  $params
     * @return mixed
     */
    public function getAdminSummaryByInterest($params)
    {
        $query = MemberInfoStatDaily::selectRaw('platform_id, SUM(deposit_credit) AS deposit_credit, SUM(interest) AS interest')
                                    ->whereBetween('bet_at', [$params['start'], $params['end']]);

        if (isset($params['platform']) && $params['platform'] > 0) {
            $query = $query->platform($params['platform']);
        }
        return $query->groupBy('platform_id')->get();
    }

    /**
     * [控端] 利息報表 - 每日總表
     *
     * @param  integer $platformId
     * @param  array   $params
     * @return mixed
     */
    public function getAdminDailyByInterest($platformId, $params)
    {
        return MemberInfoStatDaily::selectRaw('bet_at, SUM(deposit_credit) AS deposit_credit, SUM(interest) AS interest')
                                  ->whereBetween('bet_at', [$params['start'], $params['end']])
                                  ->platform($platformId)
                                  ->groupBy('bet_at')
                                  ->orderBy('bet_at', 'DESC')
                                  ->get();
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
