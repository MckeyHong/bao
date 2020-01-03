<?php

namespace App\Repositories\Member;

use App\Entities\Member\MemberLogin;
use App\Repositories\Repository;

class MemberLoginRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(MemberLogin::class);
    }
}
