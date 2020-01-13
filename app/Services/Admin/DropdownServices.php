<?php

namespace App\Services\Admin;

use App\Repositories\Platform\PlatformRepository;
use App\Repositories\Role\RoleRepository;

class DropdownServices
{
    /**
     * 下拉選單
     *
     * @param  string $type
     * @return array
     */
    public function dropdown($type)
    {
        try {
            switch ($type) {
                case 'role':
                    $repo = new RoleRepository();
                    break;
                case 'platform':
                    $repo = new PlatformRepository();
                    break;
                default:
                    throw new \Exception('not found');
            }
            $tmp = $repo->dropdown();
            return ($tmp->count() > 0) ? $tmp->toArray() : $tmp;
        } catch (\Exception $e) {
            return [];
        }
    }
}
