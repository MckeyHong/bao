<?php

namespace App\Services\Admin\System;

use Auth;
use Request;
use App\Traits\TimeTraits;
use App\Repositories\User\UserOperationRepository;

class SystemOperationServices
{
    use TimeTraits;

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
            $data = $this->userOperationRepo->getAdminList($params);
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
     * 新增操作日誌
     *
     * @param  integer  $funcId
     * @param  string   $type
     * @param  string   $targets
     * @param  string   $content
     * @return array
     */
    public function store($funcId, $type, $targets = '', $content = '')
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
