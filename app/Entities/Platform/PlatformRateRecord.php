<?php

namespace App\Entities\Platform;

use App\Entities\BaoModel;

class PlatformRateRecord extends BaoModel
{
    protected $table = 'platform_rate_record';
    protected $fillable = ['platform_id', 'date_at', 'present'];
}
