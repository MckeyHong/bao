<?php

namespace App\Traits;

use Carbon\Carbon;

trait TimeTraits
{
    /**
     * 轉換時間格式(UTC+8  → UTD+0)
     *
     * @param  datetime $dateTime [YYYY-mm-dd HH:i:s]
     * @return datetime|integer
     */
    public function covertUTC8ToUTC($dateTime)
    {
        return Carbon::parse($dateTime)->timezone('UTC')->toDateTimeString();
    }

    /**
     * 轉換時間格式(UTC+0 → UTD+8)
     *
     * @param  datetime|timestamp  $dateTime
     * @return datetime
     */
    public function covertUTCToUTC8($dateTime)
    {
        return date('Y-m-d H:i:s', (strtotime($dateTime) + (8 * 3600)));
    }
}
