<?php

namespace App\Services\Admin\System;

use DB;
use App\Traits\TimeTraits;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Role\RolePermissionRepository;

class SystemRoleServices
{
    use TimeTraits;

    protected $roleRepo;
    protected $rolePermissionRepo;

    public function __construct(
        RoleRepository $roleRepo,
        RolePermissionRepository $rolePermissionRepo
    ) {
        $this->roleRepo           = $roleRepo;
        $this->rolePermissionRepo = $rolePermissionRepo;
    }

    /**
     * 取得列表清單
     *
     * @param  array  $role
     * @return array
     */
    public function index()
    {
        try {
            $data = $this->roleRepo->getAdminList();
            foreach ($data as $value) {
                $value['is_operation'] = ($value['id'] != 1) ?: false;
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
                $role = $this->roleRepo->store([
                    'name'   => $request['name'],
                    'active' => $request['active'],
                ]);
                // 功能權限
                foreach (config('permission.func') as $cate) {
                    foreach ($cate['menu'] as $menu) {
                        $params = [
                            'role_id'   => $role['id'],
                            'path'      => $menu['path'],
                            'is_get'    => 2,
                            'is_post'   => 2,
                            'is_put'    => 2,
                            'is_delete' => 2
                        ];
                        foreach ($menu['permission'] as $action) {
                            $tmp = $menu['path'] . '-' . $action;
                            if (in_array($tmp, $request['permission'])) {
                                $params[$action] = 1;
                            }
                        }
                        $this->rolePermissionRepo->store($params);
                    }
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
                $this->roleRepo->destroy($id);
                $this->rolePermissionRepo->deleteByWhere('role_id', $id);
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
}
