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

    /**
     * 尋找某平台的會員(帳號)
     *
     * @param  integer $platformId
     * @param  string  $account
     * @param  array   $field
     * @return mixed
     */
    public function findByAccount($platformId, $account, $field = ['id'])
    {
        return Member::select($field)->platform($platformId)
                                     ->where('account', $account)
                                     ->first();
    }
}
