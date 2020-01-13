<?php

namespace App\Services\Admin;

use App\Repositories\Platform\PlatformRepository;

class DropdownServices
{
    public function getPlatform()
    {
        try {
            $repo = new PlatformRepository();
            $tmp = $repo->dropdown();
            return ($tmp->count() > 0) ? $tmp->toArray() : $tmp;
        } catch (\Exception $e) {
            return [];
        }
    }
}
