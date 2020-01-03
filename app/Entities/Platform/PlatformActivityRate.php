<?php

namespace App\Entities\Platform;

use Illuminate\Database\Eloquent\Model;

class PlatformActivityRate extends Model
{
    protected $table = 'platform_activity_rate';
    protected $fillable = ['platform_id', 'start_at', 'end_at', 'rate', 'active'];
}
