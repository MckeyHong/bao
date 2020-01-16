<?php

namespace App\Entities\User;

use App\Entities\BaoModel;

class UserOperation extends BaoModel
{
    protected $table = 'user_operation';
    protected $fillable = ['user_id', 'user_account', 'user_name', 'ip', 'func_key', 'func_id', 'type', 'targets', 'content'];
    protected $casts    = [
        'targets' => 'array',
        'content' => 'array',
    ];
}
