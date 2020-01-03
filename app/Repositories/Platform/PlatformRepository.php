<?php

namespace App\Repositories\Platform;

use App\Entities\Platform\Platform;
use App\Repositories\Repository;

class PlatformRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Platform::class);
    }
}
