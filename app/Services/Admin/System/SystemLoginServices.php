<?php

namespace App\Services\Admin\System;

use App\Traits\TimeTraits;
use App\Services\Common\AreaServices;
use App\Repositories\User\UserLoginRepository;

class SystemLoginServices
{
    use TimeTraits;

    protected $areaSrv;
    protected $userLoginRepo;

    public function __construct(
        AreaServices $areaSrv,
        UserLoginRepository $userLoginRepo
    ) {
        $this->areaSrv       = $areaSrv;
        $this->userLoginRepo = $userLoginRepo;
    }

    /**
     * 取得登入日誌列表清單
     *
     * @param  array    $params
     * @return array
     */
    public function index($params)
    {
        try {
            $data = $this->userLoginRepo->getAdminList($params);
            foreach ($data as $value) {
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

    /**
     * 新增後後帳號登入紀錄
     *
     * @param  string   $ip
     * @param  array    $user
     * @param  integer  $status
     * @return array
     */
    public function store($ip, $user = [], $status = 1)
    {
        try {
            $this->userLoginRepo->store([
                'user_id'      => $user['id'],
                'user_account' => $user['account'],
                'user_name'    => $user['name'],
                'login_ip'     => $ip,
                'area'         => $this->areaSrv->getArea($ip),
                'status'       => $status,
            ]);
            return ['result' => true];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
