<?php

namespace App\Traits;

use Carbon\Carbon;

trait TimeTraits
{
    /**
     * 轉換時間格式(UTC+8  → UTD+0)
     *
     * @param  string $dateTime
     * @param  string $format
     * @return string
     */
    public function covertUTC8ToUTC($dateTime, $format = 'datetime')
    {
        switch ($format) {
            case 'date':
                $type = 'Y-m-d';
                break;
            default:
                $type = 'Y-m-d H:i:s';
        }
        return date($type, (strtotime($dateTime) - (8 * 3600)));
    }

    /**
     * 轉換時間格式(UTC+0 → UTD+8)
     *
     * @param  string $dateTime
     * @param  string $format
     * @return string
     */
    public function covertUTCToUTC8($dateTime, $format = 'datetime')
    {
        switch ($format) {
            case 'date':
                $type = 'Y-m-d';
                break;
            default:
                $type = 'Y-m-d H:i:s';
        }
        return date($type, (strtotime($dateTime) + (8 * 3600)));
    }
}
