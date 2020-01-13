<?php

namespace App\Services\Admin\System;

use App\Repositories\Role\RoleRepository;
use App\Repositories\Role\RolePermissionRepository;

class SystemRoleServices
{
    protected $roleRepo;
    protected $rolePermissionRepo;

    public function __construct(
        RoleRepository $roleRepo,
        RolePermissionRepository $rolePermissionRepo
    ) {
        $this->roleRepo           = $roleRepo;
        $this->rolePermissionRepo = $rolePermissionRepo;
    }
}
