<?php

namespace App\Services\Common;

use GeoIP as GeoIP;

class AreaServices
{
    /**
     * 取得IP所屬地區
     *
     * @param  string $ip
     * @return string
     */
    public function getArea($ip)
    {
        try {
            $info = GeoIP::getLocation($ip);
            return ((isset($info['country']) && $info['country'] != '') ? $info['country'] . ', ' : ''). ($info['city'] ?? '');
        } catch (\Exception $e) {
            return '';
        }
    }
}
