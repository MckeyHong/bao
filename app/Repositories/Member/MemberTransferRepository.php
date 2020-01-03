<?php

namespace App\Repositories\Member;

use App\Entities\Member\MemberTransfer;
use App\Repositories\Repository;

class MemberTransferRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(MemberTransfer::class);
    }
}
