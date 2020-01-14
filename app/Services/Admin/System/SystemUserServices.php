<?php

namespace App\Services\Admin\System;

use DB;
use Illuminate\Support\Facades\Hash;
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

    /**
     * 新增
     *
     * @param  array $request
     * @return array
     */
    public function store($request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $this->userRepo->store([
                    'role_id'  => $request['role_id'],
                    'account'  => $request['account'],
                    'password' => Hash::make($request['password']),
                    'name'     => $request['name'],
                    'active'   => $request['active'],
                ]);
                return true;
            });
            return ['result' => $result];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 取得帳號資訊
     *
     * @param  integer  $id
     * @return array
     */
    public function getEdit($id)
    {
        try {
            return [
                'result' => true,
                'data'   => $this->userRepo->find($id),
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
     * 編輯
     *
     * @param  integer  $id
     * @param  array    $request
     * @return array
     */
    public function edit($id, $request)
    {
        try {
            $result = DB::transaction(function () use ($id, $request) {
                $params = [
                    'role_id'  => $request['role_id'],
                    'name'     => $request['name'],
                    'active'   => $request['active'],
                ];
                if (isset($request['password']) && $request['password'] != '') {
                    $params['password'] = Hash::make($request['password']);
                }
                $this->userRepo->update($id, $params);
                return true;
            });
            return ['result' => $result];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 刪除
     *
     * @param  integer $id
     * @return array
     */
    public function destroy($id)
    {
        try {
            return ['result' => $this->userRepo->destroy($id)];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 檢查帳號是否存在
     *
     * @param  string   $account
     * @param  integer  $id
     * @return boolean
     */
    public function checkAccountExists($account, $id)
    {
        try {
            return ($this->userRepo->checkFieldExist('account', $account, $id)->count() == 0) ?: false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
