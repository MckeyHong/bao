<?php

namespace App\Repositories\Balance;

use App\Entities\Balance\BalanceTransfer;
use App\Repositories\Repository;

class BalanceTransferRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(BalanceTransfer::class);
    }
}
