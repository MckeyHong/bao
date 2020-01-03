<?php

namespace App\Entities\Platform;

use Illuminate\Database\Eloquent\Model;

class PlatformRateRecord extends Model
{
    protected $table = 'platform_rate_record';
    protected $fillable = ['platform_id', 'present'];
}
