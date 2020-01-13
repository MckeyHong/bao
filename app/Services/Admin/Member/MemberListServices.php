<?php

namespace App\Services\Admin\Member;

use App\Repositories\Member\MemberRepository;

class MemberListServices
{
    protected $memberRepo;

    public function __construct(
        MemberRepository $memberRepo
    ) {
        $this->memberRepo = $memberRepo;
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
            $data = $this->memberRepo->getAdminList($params);
            foreach ($data as $value) {
                $value['balance'] = amount_format(($value['credit'] + $value['today_deposit'] + $value['interest']), 2);
                $value['platform_id'] = $platform[$value['platform_id']] ?? '';
            }
            return [
                'result' => true,
                'data'   => $data,
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
