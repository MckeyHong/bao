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
}
