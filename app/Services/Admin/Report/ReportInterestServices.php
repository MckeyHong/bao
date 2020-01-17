<?php

namespace App\Services\Admin\Report;

use App\Traits\TimeTraits;
use App\Repositories\Member\MemberInfoStatDailyRepository;

class ReportInterestServices
{
    use TimeTraits;

    protected $memberInfoStatDailyRepo;

    public function __construct(
        MemberInfoStatDailyRepository $memberInfoStatDailyRepo
    ) {
        $this->memberInfoStatDailyRepo = $memberInfoStatDailyRepo;
    }

    /**
     * 列表清單
     *
     * @param  array  $params
     * @param  array  $platform
     * @return array
     */
    public function index($params, $platform)
    {
        try {
            $params['start'] = $this->covertUTC8ToUTC($params['start'], 'date');
            $params['end'] = $this->covertUTC8ToUTC($params['end'], 'date');
            $total = ['deposit_credit' => 0, 'transfer_interest' => 0];
            $data = $this->memberInfoStatDailyRepo->getAdminSummaryList($params);
            foreach ($data as $value) {
                $value['platform_id'] = $platform[$value['platform_id']] ?? '';
                $total['deposit_credit'] += $value['deposit_credit'];
                $total['transfer_interest'] += $value['transfer_interest'];
            }
            return [
                'result' => true,
                'data'   => [
                    'lists' => $data,
                    'total' => $total,
                ],
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'data'   => [],
                'error'  => $e->getMessage(),
            ];
        }
    }
}
