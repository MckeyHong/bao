<?php

namespace App\Services\Common;

use Carbon\Carbon;

class InterestServices
{
    /**
     * 計算利息
     *
     * @param  float  $deposit
     * @param  float  $rate
     * @param  string $dateTime
     * @return float
     */
    public function calculateInterest($deposit, $rate, $dateTime)
    {
        try {
            $diffSeconds = Carbon::now()->diffInSeconds($dateAt);
            $interest = ((floor_format($deposit, 0) * $rate) / 31536000) * Carbon::now()->diffInSeconds($dateTime);
            return floor_format($interest, 8);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
