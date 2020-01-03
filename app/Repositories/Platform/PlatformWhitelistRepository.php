<?php

namespace App\Repositories\Platform;

use App\Entities\Platform\PlatformWhitelist;
use App\Repositories\Repository;

class PlatformWhitelistRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(PlatformWhitelist::class);
    }
}
