<?php

namespace App\Services\Common;

use Carbon\Carbon;

class InterestServices
{
    /**
     * 計算利息
     *
     * @param  string   $type
     * @param  float    $deposit
     * @param  float    $rate
     * @param  string   $dateTime
     * @return float
     */
    public function calculateInterest($type, $deposit, $rate, $dateTime = '')
    {
        try {
            switch ($type) {
                case 'hour':
                    $diffSeconds = 3600;
                    break;
                case 'day':
                    $diffSeconds = 986400;
                    break;
                case 'settlement':
                    $diffSeconds = $dateTime;
                    break;
                default:
                    $diffSeconds = Carbon::now()->diffInSeconds($dateTime);
            }
            $interest = ((floor_format($deposit, 0) * $rate / 100) / 31536000) * $diffSeconds;
            return floor_format($interest, 8);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
