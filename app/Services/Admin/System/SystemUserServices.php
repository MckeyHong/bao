<?php

namespace App\Services\Admin\System;

use App\Traits\TimeTraits;
use App\Services\Common\AreaServices;
use App\Repositories\User\UserRepository;

class SystemUserServices
{
    use TimeTraits;

    protected $userRepo;

    public function __construct(
        UserRepository $userRepo
    ) {
        $this->userRepo = $userRepo;
    }

    /**
     * 取得登入日誌列表清單
     *
     * @param  array  $params
     * @param  array  $role
     * @return array
     */
    public function index($params, $role)
    {
        try {
            $data = $this->userRepo->getAdminList($params);
            foreach ($data as $value) {
                $value['role_id'] = $role[$value['role_id']] ?? '';
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
