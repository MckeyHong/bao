<?php

namespace App\Entities\Platform;

use Illuminate\Database\Eloquent\Model;

class PlatformWhitelist extends Model
{
    protected $table = 'platform_whitelist';
    protected $fillable = ['platform_id', 'ip', 'description'];
}
