<?php

namespace App\Services\Admin\System;

use DB;
use Redis;
use Illuminate\Support\Facades\Hash;
use App\Traits\TimeTraits;
use App\Services\Common\AreaServices;
use App\Repositories\User\UserRepository;

class SystemUserServices
{
    use TimeTraits;

    protected $systemOperationSrv;
    protected $userRepo;

    public function __construct(
        SystemOperationServices $systemOperationSrv,
        UserRepository $userRepo
    ) {
        $this->systemOperationSrv = $systemOperationSrv;
        $this->userRepo           = $userRepo;
    }

    /**
     * 取得列表清單
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
                $user = $this->userRepo->store([
                    'role_id'  => $request['role_id'],
                    'account'  => $request['account'],
                    'password' => Hash::make($request['password']),
                    'name'     => $request['name'],
                    'active'   => $request['active'],
                ]);
                // 操作日誌
                $this->systemOperationSrv->store(
                    $user['id'],
                    1,
                    [['type' => 'field', 'field' => 'account', 'data' => $user['account']]],
                    [['type' => 'info', 'field' => '', 'data' => 'store']]
                );
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
     * @param  array    $role
     * @return array
     */
    public function edit($id, $request, $role)
    {
        try {
            $result = DB::transaction(function () use ($id, $request, $role) {
                $user = $this->userRepo->find($id);
                $params = $content = [];
                if ($user['role_id'] != $request['role_id']) {
                    $params['role_id'] = $request['role_id'];
                    $content[] = ['type' => 'around', 'field' => 'role', 'data' => ['old' => $role[$user['role_id']], 'new' => $role[$request['role_id']]]];
                }
                if ($user['name'] != $request['name']) {
                    $params['name'] = $request['name'];
                    $content[] = ['type' => 'around', 'field' => 'name', 'data' => ['old' => $user['name'], 'new' => $request['name']]];
                }
                if ($user['active'] != $request['active']) {
                    $params['active'] = $request['active'];
                    $content[] = ['type' => 'around', 'field' => 'active', 'data' => ['old' => $user['active'], 'new' => $request['active']]];
                    if ($request['active'] != 1) {
                        Redis::set('STRING_SINGLETOKEN_' . $id, '');
                    }
                }
                if (isset($request['password']) && $request['password'] != '') {
                    $params['password'] = Hash::make($request['password']);
                    Redis::set('STRING_SINGLETOKEN_' . $id, '');
                    $content[] = ['type' => 'info', 'field' => '', 'data' => 'password'];
                }
                if (count($params) > 0) {
                    $this->userRepo->update($id, $params);
                    // 操作日誌
                    $this->systemOperationSrv->store(
                        $id,
                        2,
                        [['type' => 'field', 'field' => 'account', 'data' => $user['account']]],
                        $content
                    );
                }
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
            $result = DB::transaction(function () use ($id) {
                $user = $this->userRepo->find($id);
                // 操作日誌
                $this->systemOperationSrv->store(
                    $id,
                    3,
                    [['type' => 'field', 'field' => 'account', 'data' => $user['account']]],
                    [['type' => 'info', 'field' => '', 'data' => 'destroy']]
                );
                return $this->userRepo->destroy($id);
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
