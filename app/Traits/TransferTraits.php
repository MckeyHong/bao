<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait TransferTraits
{
    /**
     * 取得儲值的交易單號
     *
     * @return string
     */
    public function getDepositTradeNo()
    {
        return Str::uuid();
    }

    /**
     * 取得提款的交易單號
     *
     * @return string
     */
    public function getWithdrawalTradeNo()
    {
        return Str::uuid();
    }
}
