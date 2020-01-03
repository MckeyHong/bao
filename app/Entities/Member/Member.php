<?php

namespace App\Entities\Member;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use Notifiable;

    protected $table = 'members';
    protected $fillable = ['platform_id', 'account', 'password', 'credit', 'today_deposit', 'interest', 'token',
                           'active', 'last_session'];

    protected $hidden = ['password', 'token'];
}
