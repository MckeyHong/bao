<?php

namespace App\Entities\Balance;

use Illuminate\Database\Eloquent\Model;

class BalanceTransfer extends Model
{
    protected $table = 'balance_transfer';
    protected $fillable = ['platform_id', 'member_id', 'no', 'type', 'credit_before', 'credit', 'credit_after', 'memo'];
}
