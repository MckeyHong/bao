<?php

namespace App\Services\Admin\Member;

use App\Traits\TimeTraits;
use App\Repositories\Member\MemberLoginRepository;

class MemberLoginServices
{
    use TimeTraits;

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
            $params['start'] = $this->covertUTC8ToUTC($params['start'] . ':00');
            $params['end'] = $this->covertUTC8ToUTC($params['end'] . ':00');
            $data = $this->memberLoginRepo->getAdminList($params);
            foreach ($data as $value) {
                $value['platform_id'] = $platform[$value['platform_id']] ?? '';
                $value['created_at'] = $this->covertUTCToUTC8($value['created_at']);
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
