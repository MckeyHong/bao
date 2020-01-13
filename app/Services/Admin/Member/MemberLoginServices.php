<?php

namespace App\Services\Admin\Member;

use App\Repositories\Member\MemberLoginRepository;

class MemberLoginServices
{
    protected $memberLoginRepo;

    public function __construct(
        MemberLoginRepository $memberLoginRepo
    ) {
        $this->memberLoginRepo = $memberLoginRepo;
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
            $data = $this->memberLoginRepo->getAdminList($params);
            foreach ($data as $value) {
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
