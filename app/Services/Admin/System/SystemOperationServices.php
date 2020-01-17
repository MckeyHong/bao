<?php

namespace App\Services\Admin\System;

use Auth;
use Request;
use App\Traits\AdminOperation;
use App\Traits\TimeTraits;
use App\Repositories\User\UserOperationRepository;

class SystemOperationServices
{
    use AdminOperation, TimeTraits;

    protected $userOperationRepo;

    public function __construct(
        UserOperationRepository $userOperationRepo
    ) {
        $this->userOperationRepo = $userOperationRepo;
    }

    /**
     * 取得列表清單
     *
     * @param  array    $params
     * @return array
     */
    public function index($params)
    {
        try {
            $params['start'] = $this->covertUTC8ToUTC($params['start'] . ':00');
            $params['end'] = $this->covertUTC8ToUTC($params['end'] . ':00');
            $data = $this->handleOperationInfo($this->userOperationRepo->getAdminList($params));
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
     * 單筆歷程資料
     *
     * @param  string  $funcKey
     * @param  integer $funcId
     * @return array
     */
    public function detail($funcKey, $funcId)
    {
        try {
            return [
                'code'   => 200,
                'result' => $this->handleOperationInfo($this->userOperationRepo->getAdminSingleList($funcKey, $funcId)),
            ];
        } catch (\Exception $e) {
            return [
                'code'   => 500,
                'result' => null,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 處理操作日誌資料顯示
     *
     * @param  mixed  $list
     * @return mixed
     */
    private function handleOperationInfo($list)
    {
        foreach ($list as $value) {
            $value['created_at'] = $this->covertUTCToUTC8($value['created_at']);
            $value['targets'] = $this->covertOperation($value['targets']);
            $value['content'] = $this->covertOperation($value['content']);
        }
        return $list;
    }

    /**
     * 新增操作日誌
     *
     * @param  integer  $funcId
     * @param  string   $type
     * @param  array    $targets
     * @param  array    $content
     * @return array
     */
    public function store($funcId, $type, $targets = [], $content = [])
    {
        try {
            $user = Auth::user();
            $path = Request::path();
            $tmp = explode('/', $path);
            if (count($tmp) > 3) {
                $path = $tmp[0] . '/' . $tmp[1] . '/' . $tmp[2];
            }
            $this->userOperationRepo->store([
                'user_id'      => $user['id'],
                'user_account' => $user['account'],
                'user_name'    => $user['name'],
                'ip'           => get_real_ip(Request::ip()),
                'func_key'     => config('permission.operation.' . $path, ''),
                'func_id'      => $funcId,
                'type'         => $type,
                'targets'      => $targets,
                'content'      => $content,
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
