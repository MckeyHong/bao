<?php

namespace App\Entities\Balance;

use App\Entities\BaoModel;

class BalanceTransfer extends BaoModel
{
    protected $table = 'balance_transfer';
    protected $fillable = ['platform_id', 'member_id', 'no', 'type', 'credit_before', 'credit', 'credit_after', 'is_transfer', 'memo'];
}
