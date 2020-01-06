<?php

namespace App\Repositories\Platform;

use App\Entities\Platform\PlatformActivityRate;
use App\Repositories\Repository;

class PlatformActivityRateRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(PlatformActivityRate::class);
    }

    /**
     * 取得指定平台及日期是否有活動利率
     *
     * @param  integer  $platformId
     * @param  string   $date
     * @return mixd
     */
    public function findByPlatformIdAndActivity($platformId, $date)
    {
        return PlatformActivityRate::select(['rate'])
                                    ->platform($platformId)
                                    ->active(1)
                                    ->where('start_at', '<=', $date)
                                    ->where('end_at', '>=', $date)
                                    ->first();
    }
}
