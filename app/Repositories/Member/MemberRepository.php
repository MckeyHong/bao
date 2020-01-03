<?php

namespace App\Repositories\Member;

use App\Entities\Member\Member;
use App\Repositories\Repository;

class MemberRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Member::class);
    }
}
