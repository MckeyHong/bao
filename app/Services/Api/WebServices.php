<?php

namespace App\Services\Api;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Api\Traits\Member\MemberCreditTraits;
use App\Api\Traits\Transfer\TransferCreditTraits;
use App\Services\Common\InterestServices;
use App\Services\Common\RateServices;
use App\Services\Web\RecordServices;
use App\Repositories\Balance\BalanceTransferRepository;
use App\Repositories\Member\MemberInfoStatDailyRepository;
use App\Repositories\Member\MemberRepository;
use App\Repositories\Member\MemberTransferRepository;

class WebServices
{
    use MemberCreditTraits, TransferCreditTraits;

    protected $interestSrv;
    protected $rateSrv;
    protected $recordSrv;
    protected $balanceTransferRepo;
    protected $memberInfoStatDailyRepo;
    protected $memberRepo;
    protected $memberTransferRepo;

    public function __construct(
        InterestServices $interestSrv,
        RateServices $rateSrv,
        RecordServices $recordSrv,
        BalanceTransferRepository $balanceTransferRepo,
        MemberInfoStatDailyRepository $memberInfoStatDailyRepo,
        MemberRepository $memberRepo,
        MemberTransferRepository $memberTransferRepo
    ) {
        $this->interestSrv             = $interestSrv;
        $this->rateSrv                 = $rateSrv;
        $this->recordSrv               = $recordSrv;
        $this->balanceTransferRepo     = $balanceTransferRepo;
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
                // 再檢查平台額度是否正常
                $platformCredit = $this->getMemberCreditOfApi($member['account'])['data'];
                if ($platformCredit < $credit) {
                    throw new \Exception('平台额度不足', 417);
                }
                // 平台轉帳
                $tradeNo = Str::uuid();
                $response = $this->transferCreditOfApi($member['account'], $tradeNo, 'IN', $credit);
                if ($response['result'] != config('apiCode.code.succcess')) {
                    throw new \Exception('平台转帐异常', 417);
                }
                $response = $this->checkTransferCreditOfApi($tradeNo);
                if ($response['result'] != config('apiCode.code.succcess')) {
                    throw new \Exception('平台转帐核對异常', 417);
                }
                $todayDepositBefore = bcadd($member['today_deposit'], $member['interest'], 2);
                $todayDepositAfter = bcadd($todayDepositBefore, $credit, 2);
                $this->balanceTransferRepo->store([
                    'platform_id'   => $member['platform_id'],
                    'member_id'     => $member['id'],
                    'no'            => $tradeNo,
                    'type'          => 1,
                    'credit_before' => $todayDepositBefore,
                    'credit'        => $credit,
                    'credit_after'  => $todayDepositAfter,
                ]);

                // 計算計算&歷程查詢
                $creditBefore = bcadd(($member['credit'] + $member['today_deposit']), $member['interest'], 2);
                $rate = $this->rateSrv->getPlatformRate($member['platform_id']);
                $interest = 0;
                if ($member['last_transfer_at'] != null) {
                    $interest = $this->interestSrv->calculateInterest('', $member['today_deposit'], $rate, $member['last_transfer_at']);
                }
                $this->memberTransferRepo->store([
                    'platform_id'   => $member['platform_id'],
                    'member_id'     => $member['id'],
                    'type'          => 1,
                    'credit_before' => $creditBefore,
                    'credit'        => $credit,
                    'credit_after'  => $todayDepositAfter,
                    'interest'      => $interest,
                    'rate'          => $rate,
                ]);

                // 更新會員主資訊
                $this->memberRepo->update($member['id'], [
                    'today_deposit'    => $todayDepositAfter,
                    'interest'         => bcadd($member['interest'], $interest, 8),
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
     * @param  array  member
     * @param  float  credit
     * @return array
     */
    public function withdrawal($member, $credit)
    {
        try {
            $result = DB::transaction(function () use ($member, $credit) {
                // 平台轉帳
                $tradeNo = Str::uuid();
                $response = $this->transferCreditOfApi($member['account'], $tradeNo, 'OUT', $credit);
                if ($response['result'] != config('apiCode.code.succcess')) {
                    throw new \Exception('平台转帐异常', 417);
                }
                $response = $this->checkTransferCreditOfApi($tradeNo);
                if ($response['result'] != config('apiCode.code.succcess')) {
                    throw new \Exception('平台转帐核對异常', 417);
                }
                $creditBefore = bcadd($member['today_deposit'], $member['interest'], 2);
                $this->balanceTransferRepo->store([
                    'platform_id'   => $member['platform_id'],
                    'member_id'     => $member['id'],
                    'no'            => $tradeNo,
                    'type'          => 2,
                    'credit_before' => $creditBefore,
                    'credit'        => $credit,
                    'credit_after'  => bcsub($creditBefore, $credit, 2),
                ]);

                if ($credit > $member['today_deposit']) {
                    $todayDepositAfter = 0;
                    $interestAfter = bcsub($member['interest'], ($credit - $member['today_deposit']), 2);
                } else {
                    $todayDepositAfter = bcsub($member['today_deposit'], $credit, 2);
                    $interestAfter = $member['interest'];
                }
                // 計算計算&歷程查詢
                $rate = $this->rateSrv->getPlatformRate($member['platform_id']);
                $interest = 0;
                if ($member['last_transfer_at'] != null) {
                    $interest = $this->interestSrv->calculateInterest('', $member['today_deposit'], $rate, $member['last_transfer_at']);
                }
                $this->memberTransferRepo->store([
                    'platform_id'   => $member['platform_id'],
                    'member_id'     => $member['id'],
                    'type'          => 2,
                    'credit_before' => $creditBefore,
                    'credit'        => $credit,
                    'credit_after'  => $todayDepositAfter,
                    'interest'      => $interest,
                    'rate'          => $rate,
                ]);

                // 更新會員主資訊
                $this->memberRepo->update($member['id'], [
                    'today_deposit'    => $todayDepositAfter,
                    'interest'         => $interestAfter,
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
