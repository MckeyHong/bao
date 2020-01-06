<?php

namespace App\Entities\Platform;

use App\Entities\BaoModel;

class PlatformActivityRate extends BaoModel
{
    protected $table = 'platform_activity_rate';
    protected $fillable = ['platform_id', 'start_at', 'end_at', 'rate', 'active'];
}
