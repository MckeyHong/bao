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

    /**
     * [控端] 列表清單
     *
     * @return mixed
     */
    public function getAdminList()
    {
        return Role::select(['id', 'name', 'active', 'created_at'])
                    ->orderBy('created_at', 'DESC')
                    ->paginate(config('custom.admin.paginate'));
    }
}
