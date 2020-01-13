<?php

namespace App\Entities\Role;

use App\Entities\BaoModel;

class RolePermission extends BaoModel
{
    protected $table = 'role_permission';
    protected $fillable = ['role_id', 'path', 'is_get', 'is_post', 'is_put', 'is_delete'];
}
