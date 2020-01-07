<?php

namespace App\Entities\Member;

use App\Entities\BaoModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Member extends BaoModel implements AuthorizableContract, AuthenticatableContract
{
    use Authenticatable, Authorizable, Notifiable;

    protected $table = 'members';
    protected $fillable = ['platform_id', 'account', 'name', 'password', 'credit', 'today_deposit', 'interest', 'api_token',
                           'active', 'last_session', 'last_transfer_at'];

    protected $hidden = ['password', 'api_token'];
}
