<?php

namespace App\Entities\Member;

use App\Entities\BaoModel;

class MemberLogin extends BaoModel
{
    protected $table = 'member_login';
    protected $fillable = ['platform_id', 'member_id', 'member_account', 'member_name', 'login_ip', 'device', 'area'];
}
