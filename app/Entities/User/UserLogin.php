<?php

namespace App\Entities\User;

use App\Entities\BaoModel;

class UserLogin extends BaoModel
{
    protected $table = 'user_login';
    protected $fillable = ['user_id', 'user_account', 'user_name', 'login_ip', 'area', 'status'];
}
