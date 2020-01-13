<?php

namespace App\Repositories\User;

use App\Entities\User\UserOperation;
use App\Repositories\Repository;

class UserOperationRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(UserOperation::class);
    }
}
