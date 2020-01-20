<?php

namespace App\Services\Api;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Api\Traits\Member\MemberCreditTraits;
use App\Api\Traits\Transfer\TransferCreditTraits;
use App\Services\Common\InterestServices;
use App\Services\Common\RateServices;
use App\Services\Common\TrasnferServices;
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
    protected $trasnferSrv;
    protected $recordSrv;
    protected $balanceTransferRepo;
    protected $memberInfoStatDailyRepo;
    protected $memberRepo;
    protected $memberTransferRepo;

    public function __construct(
        InterestServices $interestSrv,
        RateServices $rateSrv,
        TrasnferServices $trasnferSrv,
        RecordServices $recordSrv,
        BalanceTransferRepository $balanceTransferRepo,
        MemberInfoStatDailyRepository $memberInfoStatDailyRepo,
        MemberRepository $memberRepo,
        MemberTransferRepository $memberTransferRepo
    ) {
        $this->interestSrv             = $interestSrv;
        $this->rateSrv                 = $rateSrv;
        $this->trasnferSrv             = $trasnferSrv;
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
                // 計算之前已儲值利息
                $creditBefore = bcadd(($member['credit'] + $member['today_deposit']), $member['interest'], 8);
                $interest = 0;
                $rate = $this->rateSrv->getPlatformRate($member['platform_id']);
                if ($member['today_deposit'] > 0) {
                    $interest = $this->interestSrv->calculateInterest('', $member['today_deposit'], $rate, $member['last_transfer_at']);
                }
                if ($interest > 0) {
                    $this->memberRepo->update($member['id'], ['interest' => bcadd($member['interest'], $interest, 8)]);
                }
                // 平台轉帳
                $result = $this->trasnferSrv->platform($member, $credit);
                if ($result['result']) {
                    $this->memberTransferRepo->store([
                        'platform_id'   => $member['platform_id'],
                        'member_id'     => $member['id'],
                        'type'          => 1,
                        'credit_before' => $creditBefore,
                        'credit'        => $credit,
                        'credit_after'  => bcadd(($creditBefore + $interest), $credit, 8),
                        'interest'      => $interest,
                        'rate'          => $rate,
                    ]);

                    // 更新會員主資訊
                    $this->memberRepo->update($member['id'], [
                        'today_deposit'    => bcadd($member['today_deposit'], $credit, 2),
                        'last_transfer_at' => Carbon::now()->toDateTimeString(),
                    ]);
                    // 更新統計資訊
                    $this->memberInfoStatDailyRepo->updateByWeb($member['id'], Carbon::now()->toDateString(), $credit, $interest);
                }
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
                // 計算之前已儲值利息
                $creditBefore = bcadd(($member['credit'] + $member['today_deposit']), $member['interest'], 8);
                $interest = 0;
                $rate = $this->rateSrv->getPlatformRate($member['platform_id']);
                if ($member['today_deposit'] > 0) {
                    $interest = $this->interestSrv->calculateInterest('', $member['today_deposit'], $rate, $member['last_transfer_at']);
                }
                if ($interest > 0) {
                    $this->memberRepo->update($member['id'], ['interest' => bcadd($member['interest'], $interest, 8)]);
                }
                // 平台轉帳
                $result = $this->trasnferSrv->platform($member, $credit, 'OUT');
                if ($result['result']) {
                    $this->memberTransferRepo->store([
                        'platform_id'   => $member['platform_id'],
                        'member_id'     => $member['id'],
                        'type'          => 2,
                        'credit_before' => $creditBefore,
                        'credit'        => $credit,
                        'credit_after'  => bcsub(($creditBefore + $interest), $credit, 8),
                        'interest'      => $interest,
                        'rate'          => $rate,
                    ]);
                    // 更新會員主資訊
                    $this->memberRepo->update($member['id'], [
                        'today_deposit'    => bcsub($member['today_deposit'], $credit, 2),
                        'last_transfer_at' => Carbon::now()->toDateTimeString(),
                    ]);
                    // 更新統計資訊
                    $this->memberInfoStatDailyRepo->updateByWeb($member['id'], Carbon::now()->toDateString(), $credit, $interest, '-');
                }
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
