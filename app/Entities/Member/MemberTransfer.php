<?php

namespace App\Entities\Member;

use Illuminate\Database\Eloquent\Model;

class MemberTransfer extends Model
{
    protected $table = 'member_transfer';
    protected $fillable = ['platform_id', 'type', 'member_id', 'credit_before', 'credit', 'credit_after', 'interest', 'rate'];
}
