<?php

namespace App\Entities\Member;

use Illuminate\Database\Eloquent\Model;

class MemberLogin extends Model
{
    protected $table = 'member_login';
    protected $fillable = ['platform_id', 'member_id', 'member_account', 'member_name', 'login_ip', 'device', 'area'];
}
