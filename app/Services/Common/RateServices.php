<?php

namespace App\Services\Common;

use Cache;
use Carbon\Carbon;
use App\Repositories\Platform\PlatformActivityRateRepository;
use App\Repositories\Platform\PlatformRepository;

class RateServices
{
    /**
     * 取得平台利率
     *
     * @param  integer $platformId
     * @param  string  $date         [Ex.2020-01-06]
     * @return float
     */
    public function getPlatformRate($platformId, $date = '')
    {
        try {
            $date = (validate_date($date)) ? Carbon::now()->toDateString() : $date;
            if (Cache::tags(['rate', $date])->has($platformId)) {
                return Cache::tags(['rate', $date])->get($platformId);
            } else {
                // 先檢查是否有活動利率
                $repo = new PlatformActivityRateRepository();
                $activity = $repo->findByPlatformIdAndActivity($platformId, $date);
                if ($activity != null) {
                    $rate = floatval($activity['rate'] ?? 0);
                } else {
                    $repo = new PlatformRepository();
                    $platform = $repo->find($platformId);
                    $rate = floatval($platform['present'] ?? 0);
                }
                Cache::tags(['rate', $date])->put($platformId, $rate, now()->addMinutes(1440));
                return $rate;
            }
        } catch (\Exception $e) {
            return 0;
        }
    }
}
