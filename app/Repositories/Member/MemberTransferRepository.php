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
        return MemberTransfer::select(['type', 'credit_before', 'credit', 'credit_after', 'interest', 'created_at'])
                            ->member($memberId)
                            ->whereBetween('created_at', [$startAt, $endAt])
                            ->orderBy('created_at', 'DESC')
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

    /**
     * [控端] 會員歷程查詢
     *
     * @param  array  $params
     * @return mixed
     */
    public function getAdminList($params)
    {
        $query = MemberTransfer::select(['members.account', 'member_transfer.platform_id', 'member_transfer.type', 'member_transfer.credit_before', 'member_transfer.credit', 'member_transfer.credit_after', 'member_transfer.interest', 'member_transfer.created_at'])
                               ->leftjoin('members', 'members.id', '=', 'member_transfer.member_id')
                               ->whereBetween('member_transfer.created_at', [$params['start'], $params['end']]);

        if (isset($params['platform']) && $params['platform'] > 0) {
            $query = $query->where('member_transfer.platform_id', $params['platform']);
        }
        if (isset($params['account']) && $params['account'] != '') {
            $query = $query->where('members.account', $params['account']);
        }

        return $query->orderBy('member_transfer.created_at', 'DESC')
                     ->paginate(config('custom.admin.paginate'));
    }
}
