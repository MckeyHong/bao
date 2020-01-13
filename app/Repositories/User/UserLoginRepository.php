<?php

namespace App\Repositories\User;

use App\Entities\User\UserLogin;
use App\Repositories\Repository;

class UserLoginRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(UserLogin::class);
    }
}
