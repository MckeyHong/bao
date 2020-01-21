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
            $total = ['deposit_credit' => 0, 'interest' => 0];
            $data = $this->memberInfoStatDailyRepo->getAdminSummaryByInterest($params);
            foreach ($data as $value) {
                $value['platform_name'] = $platform[$value['platform_id']] ?? '';
                $total['deposit_credit'] += $value['deposit_credit'];
                $total['interest'] += $value['interest'];
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
                'data'   => [
                    'lists' => $data,
                    'total' => $total,
                ],
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 明細清單
     *
     * @param  integer  $platformId
     * @param  array    $params
     * @return array
     */
    public function detail($platformId, $params)
    {
        try {
            $params['start'] = $this->covertUTC8ToUTC($params['start'], 'date');
            $params['end'] = $this->covertUTC8ToUTC($params['end'], 'date');
            $total = ['deposit_credit' => 0, 'interest' => 0];
            $data = $this->memberInfoStatDailyRepo->getAdminDailyByInterest($platformId, $params);
            foreach ($data as $value) {
                $total['deposit_credit'] += $value['deposit_credit'];
                $total['interest'] += $value['interest'];
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
