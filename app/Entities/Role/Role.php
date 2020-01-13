<?php

namespace App\Entities\Role;

use App\Entities\BaoModel;

class Role extends BaoModel
{
    protected $table = 'roles';
    protected $fillable = ['name', 'active'];
}
