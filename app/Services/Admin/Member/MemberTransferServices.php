<?php

namespace App\Services\Admin\Member;

use App\Traits\TimeTraits;
use App\Repositories\Member\MemberTransferRepository;

class MemberTransferServices
{
    use TimeTraits;

    protected $memberTransferRepo;

    public function __construct(
        MemberTransferRepository $memberTransferRepo
    ) {
        $this->memberTransferRepo = $memberTransferRepo;
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
            $data = [];
            $params['start'] = $this->covertUTC8ToUTC($params['start'] . ':00');
            $params['end'] = $this->covertUTC8ToUTC($params['end'] . ':59');
            $data = $this->memberTransferRepo->getAdminList($params);
            foreach ($data as $value) {
                $value['platform_id'] = $platform[$value['platform_id']] ?? '';
                $value['created_at'] = $this->covertUTCToUTC8($value['created_at']);
            }
            return [
                'result' => true,
                'data'   => $data,
            ];
        } catch (\Exception $e) {
            dd($e->getMessage());
            return [
                'result' => false,
                'data'   => [],
                'error'  => $e->getMessage(),
            ];
        }
    }
}
