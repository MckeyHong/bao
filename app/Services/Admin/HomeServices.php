<?php

namespace App\Services\Admin;

use Carbon\Carbon;
use App\Services\Common\RateServices;
use App\Repositories\Member\MemberTransferRepository;
use App\Repositories\Platform\PlatformActivityRateRepository;
use App\Repositories\Platform\PlatformRepository;

class HomeServices
{
    protected $rateSrv;
    protected $memberTransferRepo;
    protected $platformActivityRateRepo;
    protected $platformRepo;

    public function __construct(
        RateServices $rateSrv,
        MemberTransferRepository $memberTransferRepo,
        PlatformActivityRateRepository $platformActivityRateRepo,
        PlatformRepository $platformRepo
    ) {
        $this->rateSrv                  = $rateSrv;
        $this->memberTransferRepo       = $memberTransferRepo;
        $this->platformActivityRateRepo = $platformActivityRateRepo;
        $this->platformRepo             = $platformRepo;
    }

    /**
     * 下拉選單
     *
     * @return array
     */
    public function index()
    {
        try {
            $data = ['total' => ['depositAmount' => 0, 'interest' => 0, 'depositCount' => 0, 'withdrawalCount' => 0], 'lists' => []];
            // 總表
            $total = $this->memberTransferRepo->getByAdminDashboard(Carbon::now()->subDay(1)->toDateTimeString());
            foreach ($total as $value) {
                switch ($value['type']) {
                    case '1':
                        $data['total']['depositAmount'] += $value['credit'];
                        $data['total']['depositCount'] += $value['cnt'];
                        break;
                    case '2':
                        $data['total']['withdrawalCount'] += $value['cnt'];
                        break;
                    default:
                }
                $data['total']['interest'] += $value['interest'];
            }
            // 今日平台利率清單
            $activity = $this->platformActivityRateRepo->getByDate(Carbon::now()->toDateString());
            $data['lists'] = $this->platformRepo->getAll(['id', 'name', 'present']);
            foreach ($data['lists'] as $value) {
                $value['activity'] = false;
                if (isset($activity[$value['id']])) {
                    $value['activity'] = true;
                    $value['present'] = $activity[$value['id']];
                    unset($activity[$value['id']]);
                }
            }

            return [
                'result' => true,
                'data'   => $data,
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
