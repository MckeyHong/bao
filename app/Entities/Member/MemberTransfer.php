<?php

namespace App\Entities\Member;

use App\Entities\BaoModel;

class MemberTransfer extends BaoModel
{
    protected $table = 'member_transfer';
    protected $fillable = ['platform_id', 'type', 'member_id', 'credit_before', 'credit', 'credit_after', 'interest', 'rate'];
}
