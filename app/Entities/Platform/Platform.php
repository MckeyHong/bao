<?php

namespace App\Entities\Platform;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $table = 'platforms';
    protected $fillable = ['name', 'present', 'future', 'active', 'api_info'];
    protected $casts = [
        'api_info' => 'array',
    ];
}
