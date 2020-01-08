<?php

namespace App\Repositories\Member;

use App\Entities\Member\MemberTransfer;
use App\Repositories\Repository;

class MemberTransferRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(MemberTransfer::class);
    }

    /**
     * 取得會員指定區間的明細
     *
     * @param  integer  $memberId
     * @param  string   $startAt
     * @param  string   $endAt
     * @param  array    $field
     * @return mixed
     */
    public function getMemberRecordList($memberId, $startAt, $endAt, $field = ['*'])
    {
        return MemberTransfer::select(['type', 'credit_before', 'credit', 'credit_after', 'created_at'])
                            ->member($memberId)
                            ->whereBetween('created_at', [$startAt, $endAt])
                            ->simplePaginate(10);
    }

    /**
     * 取得會員指定區間的明細總計
     *
     * @param  integer  $memberId
     * @param  string   $startAt
     * @param  string   $endAt
     * @return float
     */
    public function getMemberRecordTotal($memberId, $startAt, $endAt)
    {
        return MemberTransfer::member($memberId)
                            ->whereBetween('created_at', [$startAt, $endAt])
                            ->sum('interest');
    }
}
