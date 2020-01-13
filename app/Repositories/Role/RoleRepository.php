<?php

namespace App\Repositories\Role;

use App\Entities\Role\Role;
use App\Repositories\Repository;

class RoleRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Role::class);
    }
}
