<?php

namespace App\Services\Web;

use Auth;
use Carbon\Carbon;
use App\Services\Common\InterestServices;
use App\Services\Common\RateServices;
use App\Repositories\Member\MemberInfoStatDailyRepository;

class HomeServices
{
    protected $interestSrv;
    protected $rateSrv;
    protected $memberInfoStatDailyRepo;

    public function __construct(
        InterestServices $interestSrv,
        RateServices $rateSrv,
        MemberInfoStatDailyRepository $memberInfoStatDailyRepo
    ) {
        $this->interestSrv             = $interestSrv;
        $this->rateSrv                 = $rateSrv;
        $this->memberInfoStatDailyRepo = $memberInfoStatDailyRepo;
    }

    /**
     * 首頁資訊
     *
     * @return array
     */
    public function index()
    {
        try {
            $member = Auth::guard('web')->user();
            $rate = $this->rateSrv->getPlatformRate($member['platform_id']);
            $record = $this->memberInfoStatDailyRepo->findByMemberIdAndBetAt($member['id'], Carbon::now()->toDateString());
            $betTotal = $record['bet_total'] ?? 0;
            return [
                'result' => true,
                'data'   => [
                    'rate'            => $rate,
                    'betTotal'        => $betTotal,
                    'default_deposit' => $betTotal - $member['today_deposit'],
                    'example'         => $this->getExampleInterest($rate),
                ],
                'error'  => null,
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'data'   => ['rate' => 0, 'betTotal' => 0, 'default_deposit' => 0, 'exmpale' => []],
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 取得範例利息計算清單
     *
     * @param  float  $rate
     * @return array
     */
    public function getExampleInterest($rate)
    {
        try {
            $example = [
                ['amount' => 100, 'hour' => 0, 'day' => 0],
                ['amount' => 1000, 'hour' => 0, 'day' => 0],
                ['amount' => 5000, 'hour' => 0, 'day' => 0],
            ];
            foreach ($example as $key => $value) {
                $example[$key]['hour'] = amount_format($this->interestSrv->calculateInterest('hour', $value['amount'], $rate));
                $example[$key]['day'] = amount_format($this->interestSrv->calculateInterest('day', $value['amount'], $rate));
                $example[$key]['amount'] = amount_format($value['amount']);
            }
            return $example;
        } catch (\Exception $e) {
            return $example;
        }
    }
}
