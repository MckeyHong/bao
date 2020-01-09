<?php

namespace App\Services\Api;

use Carbon\Carbon;
use App\Services\Common\InterestServices;
use App\Services\Common\RateServices;
use App\Services\Web\RecordServices;
use App\Repositories\Member\MemberInfoStatDailyRepository;
use App\Repositories\Member\MemberRepository;
use App\Repositories\Member\MemberTransferRepository;

class WebServices
{
    protected $interestSrv;
    protected $rateSrv;
    protected $recordSrv;
    protected $memberInfoStatDailyRepo;
    protected $memberRepo;
    protected $memberTransferRepo;

    public function __construct(
        InterestServices $interestSrv,
        RateServices $rateSrv,
        RecordServices $recordSrv,
        MemberInfoStatDailyRepository $memberInfoStatDailyRepo,
        MemberRepository $memberRepo,
        MemberTransferRepository $memberTransferRepo
    ) {
        $this->interestSrv             = $interestSrv;
        $this->rateSrv                 = $rateSrv;
        $this->recordSrv               = $recordSrv;
        $this->memberInfoStatDailyRepo = $memberInfoStatDailyRepo;
        $this->memberRepo              = $memberRepo;
        $this->memberTransferRepo      = $memberTransferRepo;
    }

    /**
     * 取得可充值的上限
     *
     * @param  integer $memberId
     * @return mixed
     */
    public function getTodayBetTotal($memberId)
    {
        try {
            $tmp = $this->memberInfoStatDailyRepo->findByMemberIdAndBetAt($memberId, Carbon::now()->toDateString());
            return $tmp['bet_total'] ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * 立即存入
     *
     * @param  array  member
     * @param  float  credit
     * @return array
     */
    public function deposit($member, $credit)
    {
        try {
            $result = DB::transaction(function () use ($member, $credit) {
                $creditBefore = bcadd($member['credit'] + $member['today_deposit'] + $member['interest'], 2);
                $this->memberTransferRepo->store([
                    'platform_id'   => $member['platform_id'],
                    'member_id'     => $member['id'],
                    'type'          => 1,
                    'credit_before' => $creditBefore,
                    'credit'        => $credit,
                    'credit_after'  => bcadd($creditBefore + $credit, 2),
                ]);
                $this->memberRepo->update($member['id'], [
                    'today_deposit'    => bcadd($member['today_deposit'] + $credit, 2),
                    'last_transfer_at' => Carbon::now()->toDateTimeString(),
                ]);
                return true;
            });

            return [
                'code'   => 200,
                'result' => $result,
            ];
        } catch (\Exception $e) {
            return [
                'code'   => $e->getCode() ?? 500,
                'result' => [],
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 一鍵提領
     *
     * @param  array. $memberId
     * @return array
     */
    public function withdrawal($request)
    {
        try {
            $data = [];
            return [
                'result' => true,
                'data'   => $data,
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 歷程查詢
     *
     * @param  array $member
     * @param  array $request
     * @return array
     */
    public function record($member, $request)
    {
        try {
            $record = $this->recordSrv->getRecordList($member['id'], $request['start'], $request['end']);
            $total = 0;
            if ($request['page'] == 1) {
                $total = $this->recordSrv->getRecordTotal($member['id'], $request['start'], $request['end']);
            }
            return [
                'code'   => 200,
                'result' => [
                    'more'  => $record->hasMorePages(),
                    'list'  => $record,
                    'total' => $total,
                ],
            ];
        } catch (\Exception $e) {
            return [
                'code'   => $e->getCode() ?? 500,
                'result' => [],
                'error'  => $e->getMessage(),
            ];
        }
    }
}
