<?php

namespace App\Repositories\Platform;

use App\Entities\Platform\PlatformRateRecord;
use App\Repositories\Repository;

class PlatformRateRecordRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(PlatformRateRecord::class);
    }
}
