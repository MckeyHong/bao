<?php

namespace App\Services\Admin\Report;

use App\Traits\TimeTraits;
use App\Repositories\Member\MemberInfoStatDailyRepository;

class ReportMemberServices
{
    use TimeTraits;

    protected $memberInfoStatDailyRepo;

    public function __construct(
        MemberInfoStatDailyRepository $memberInfoStatDailyRepo
    ) {
        $this->memberInfoStatDailyRepo = $memberInfoStatDailyRepo;
    }

    /**
     * 取得列表清單
     *
     * @param  array    $params
     * @param  array    $platform
     * @return array
     */
    public function index($params, $platform)
    {
        try {
            $params['start'] = $this->covertUTC8ToUTC($params['start'], 'date');
            $params['end'] = $this->covertUTC8ToUTC($params['end'], 'date');
            $data = [];
            $total = ['deposit_credit' => 0, 'interest' => 0];
            if ($params['platform'] > 0 && $params['account'] != '') {
                $data = $this->memberInfoStatDailyRepo->getAdminSummaryByMember($params);
                foreach ($data as $value) {
                    $total['deposit_credit'] += $value['deposit_credit'];
                    $total['interest'] += $value['interest'];
                }
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
}
