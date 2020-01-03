<?php

namespace App\Repositories\Platform;

use App\Entities\Platform\PlatformActivityRate;
use App\Repositories\Repository;

class PlatformActivityRateRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(PlatformActivityRate::class);
    }
}
