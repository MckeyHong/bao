<?php

namespace App\Entities\Member;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = ['platform_id', 'account', 'password', 'credit', 'today_deposit', 'interest', 'token',
                           'active', 'last_session'];

    protected $hidden = ['password', 'token'];
}
