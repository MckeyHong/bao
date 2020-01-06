<?php

namespace App\Entities\Platform;

use App\Entities\BaoModel;

class PlatformWhitelist extends BaoModel
{
    protected $table = 'platform_whitelist';
    protected $fillable = ['platform_id', 'ip', 'description'];
}
