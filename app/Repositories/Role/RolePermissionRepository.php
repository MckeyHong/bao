<?php

namespace App\Repositories\Role;

use App\Entities\Role\RolePermission;
use App\Repositories\Repository;

class RolePermissionRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(RolePermission::class);
    }

    /**
     * 取得指定角色Id的功能權限設定清單
     *
     * @param  integer $roleId
     * @return mixed
     */
    public function getListByRoleId($roleId)
    {
        return RolePermission::select(['path', 'is_get', 'is_post', 'is_put', 'is_delete'])
                             ->where('role_id', $roleId)
                             ->get();
    }
}
