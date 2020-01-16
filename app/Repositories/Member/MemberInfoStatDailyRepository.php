<?php

namespace App\Repositories\Member;

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
    public function findByMemberIdAndBetAt($memberId, $betAt, $field = ['bet_total'])
    {
        return MemberInfoStatDaily::select($field)
                                  ->member($memberId)
                                  ->where('bet_at', $betAt)
                                  ->first();
    }
}
