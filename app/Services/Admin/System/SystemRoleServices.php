<?php

namespace App\Services\Admin\System;

use DB;
use App\Traits\TimeTraits;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Role\RolePermissionRepository;

class SystemRoleServices
{
    use TimeTraits;

    protected $systemOperationSrv;
    protected $roleRepo;
    protected $rolePermissionRepo;

    public function __construct(
        SystemOperationServices $systemOperationSrv,
        RoleRepository $roleRepo,
        RolePermissionRepository $rolePermissionRepo
    ) {
        $this->systemOperationSrv = $systemOperationSrv;
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
                $this->storePermission($role['id'], $request['permission']);
                $this->systemOperationSrv->store($role['id'], 1, $role['name']);
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
     * 取得角色資訊
     *
     * @param  integer  $id
     * @return array
     */
    public function getEdit($id)
    {
        try {
            $permission = config('permission.func');
            $exists = $this->rolePermissionRepo->getByWhere('role_id', $id, ['path', 'is_get', 'is_post', 'is_put', 'is_delete'])->keyBy('path')->all();
            $allCheck = true;
            $allIndeterminate = false;
            foreach ($permission as $cateKey => $cateValue) {
                $permission[$cateKey]['check'] = true;
                $permission[$cateKey]['indeterminate'] = false;
                foreach ($cateValue['menu'] as $menuKey => $menuValue) {
                    $permission[$cateKey]['menu'][$menuKey]['check'] = true;
                    $permission[$cateKey]['menu'][$menuKey]['indeterminate'] = false;
                    $permission[$cateKey]['menu'][$menuKey]['permission_check'] = [];
                    foreach ($menuValue['permission'] as $permissionKey => $permissionValue) {
                        if (($exists[$menuValue['path']][$permissionValue] ?? 2) == 1) {
                            $permission[$cateKey]['menu'][$menuKey]['permission_check'][] = true;
                            $permission[$cateKey]['menu'][$menuKey]['indeterminate'] = true;
                            $permission[$cateKey]['indeterminate'] = true;
                            $allIndeterminate = true;
                        } else {
                            $permission[$cateKey]['menu'][$menuKey]['permission_check'][] = false;
                            $permission[$cateKey]['check'] = $permission[$cateKey]['menu'][$menuKey]['check'] = false;
                            $allCheck = false;
                        }
                    }
                }
            }

            return [
                'result' => true,
                'data'   => [
                    'role'             => $this->roleRepo->find($id),
                    'allCheck'         => $allCheck,
                    'allIndeterminate' => $allIndeterminate,
                    'permission'       => $permission,
                ],
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'data'   => ['role' => [], 'allCheck' => false, 'allIndeterminate' => false, 'permission' => []],
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
                $role = $this->roleRepo->find($id);
                // 更新主資料
                $this->roleRepo->update($id, [
                    'name'   => $request['name'],
                    'active' => $request['active'],
                ]);
                // 功能權限
                $this->rolePermissionRepo->deleteByWhere('role_id', $id);
                $this->storePermission($id, $request['permission']);
                $this->systemOperationSrv->store($id, 2, $role['name']);
                return true;
            });
            return ['result' => $result];


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
                $role = $this->roleRepo->find($id);
                $this->roleRepo->destroy($id);
                $this->rolePermissionRepo->deleteByWhere('role_id', $id);
                $this->systemOperationSrv->store($id, 3, $role['name']);
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
     * 新增功能權限設定
     *
     * @param  integer  $roleId
     * @param  array    $permission
     * @return array
     */
    private function storePermission($roleId, $permission)
    {
        try {
            foreach (config('permission.func') as $cate) {
                foreach ($cate['menu'] as $menu) {
                    $params = [
                        'role_id'   => $roleId,
                        'path'      => $menu['path'],
                        'is_get'    => 2,
                        'is_post'   => 2,
                        'is_put'    => 2,
                        'is_delete' => 2
                    ];
                    foreach ($menu['permission'] as $action) {
                        $tmp = $menu['path'] . '-' . $action;
                        if (in_array($tmp, $permission)) {
                            $params[$action] = 1;
                        }
                    }
                    $this->rolePermissionRepo->store($params);
                }
            }
            return ['result' => $result];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
