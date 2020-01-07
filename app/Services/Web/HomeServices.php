<?php

namespace App\Services\Web;

use Auth;
use Carbon\Carbon;
use App\Services\Common\RateServices;
use App\Repositories\Member\MemberInfoStatDailyRepository;

class HomeServices
{
    protected $rateSrv;
    protected $memberInfoStatDailyRepo;

    public function __construct(
        RateServices $rateSrv,
        MemberInfoStatDailyRepository $memberInfoStatDailyRepo
    ) {
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
            $data = [
                'rate'     => 0,
                'betTotal' => 0,
            ];
            $member = Auth::guard('web')->user();
            $data['rate'] = $this->rateSrv->getPlatformRate($member['platform_id']);
            $tmp = $this->memberInfoStatDailyRepo->findByMemberIdAndBetAt($member['id'], Carbon::now()->toDateString());
            $data['betTotal'] = $tmp['bet_total'] ?? 0;
            return [
                'result' => true,
                'data'   => $data,
                'error'  => null,
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'data'   => $data,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
