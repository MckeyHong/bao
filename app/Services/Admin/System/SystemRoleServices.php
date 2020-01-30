<?php

namespace App\Services\Admin\System;

use DB;
use Redis;
use App\Traits\TimeTraits;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Role\RolePermissionRepository;
use App\Repositories\User\UserRepository;

class SystemRoleServices
{
    use TimeTraits;

    protected $systemOperationSrv;
    protected $roleRepo;
    protected $rolePermissionRepo;
    protected $userRepo;

    public function __construct(
        SystemOperationServices $systemOperationSrv,
        RoleRepository $roleRepo,
        RolePermissionRepository $rolePermissionRepo,
        UserRepository $userRepo
    ) {
        $this->systemOperationSrv = $systemOperationSrv;
        $this->roleRepo           = $roleRepo;
        $this->rolePermissionRepo = $rolePermissionRepo;
        $this->userRepo           = $userRepo;
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
                // 操作日誌
                $this->systemOperationSrv->store(
                    $role['id'],
                    1,
                    [['type' => 'field', 'field' => 'name', 'data' => $role['name']]],
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
                $params = $content = [];
                foreach (['name', 'active'] as $field) {
                    if ($role[$field] != $request[$field]) {
                        $params[$field] = $request[$field];
                        $content[] = ['type' => 'around', 'field' => $field, 'data' => ['old' => $role[$field], 'new' => $request[$field]]];
                    }
                    if ($request['active'] != 1) {
                        $users = $this->userRepo->getByWhere('role_id', $id, ['id']);
                        foreach ($users as $value) {
                            Redis::set('STRING_SINGLETOKEN_' . $value['id'], '');
                        }
                    }
                }
                if (count($params) > 0) {
                    // 更新主資料
                    $this->roleRepo->update($id, [
                        'name'   => $request['name'],
                        'active' => $request['active'],
                    ]);
                }

                $contentOperation = ['add' => [], 'delete' => []];
                $permission = $oldPermission = [];
                $tmp = $this->rolePermissionRepo->getByWhere('role_id', $id, ['path', 'is_get', 'is_post', 'is_put', 'is_delete']);
                foreach ($tmp as $value) {
                    foreach (['is_get', 'is_post', 'is_put', 'is_delete'] as $field) {
                        if ($value[$field] == '1') {
                            $oldPermission[] = $value['path'] . '-' . $field;
                        }
                    }
                }
                foreach (config('permission.func') as $cate) {
                    foreach ($cate['menu'] as $menu) {
                        $permission[$menu['path']] = $menu['key'];
                    }
                }
                $check = [
                    ['left' => $request['permission'], 'right' => $oldPermission, 'type' => 'add'],
                    ['left' => $oldPermission, 'right' => $request['permission'], 'type' => 'delete'],
                ];
                foreach ($check as $value) {
                    $compare = array_diff($value['left'], $value['right']);
                    if (count($compare) > 0) {
                        foreach ($compare as $compValue) {
                            $tmp = explode('-', $compValue);
                            $tmpKey = $permission[$tmp[0]];
                            $contentOperation[$value['type']][$permission[$tmp[0]]][] = $tmp[1];
                        }
                    }
                }

                if (count($contentOperation['add']) > 0 || count($contentOperation['delete']) > 0) {
                    // 功能權限
                    $this->rolePermissionRepo->deleteByWhere('role_id', $id);
                    $this->storePermission($id, $request['permission']);
                    $content[] = ['type' => 'permission', 'field' => '', 'data' => $contentOperation];
                }

                // 操作日誌
                if (count($content) > 0) {
                    $this->systemOperationSrv->store(
                        $role['id'],
                        2,
                        [['type' => 'field', 'field' => 'name', 'data' => $role['name']]],
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
                $role = $this->roleRepo->find($id);
                $this->roleRepo->destroy($id);
                $this->rolePermissionRepo->deleteByWhere('role_id', $id);
                // 操作日誌
                $this->systemOperationSrv->store(
                    $role['id'],
                    3,
                    [['type' => 'field', 'field' => 'name', 'data' => $role['name']]],
                    [['type' => 'info', 'field' => '', 'data' => 'destroy']]
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
