<?php

namespace App\Entities\Platform;

use App\Entities\BaoModel;

class Platform extends BaoModel
{
    protected $table = 'platforms';
    protected $fillable = ['name', 'present', 'future', 'active', 'api_key', 'encrypt_key'];
}
