<?php

namespace App\Repositories\User;

use App\Entities\User\User;
use App\Repositories\Repository;

class UserRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(User::class);
    }
}
