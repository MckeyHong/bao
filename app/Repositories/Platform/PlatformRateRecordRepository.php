<?php

namespace App\Repositories\Platform;

use App\Entities\Platform\PlatformRateRecord;
use App\Repositories\Repository;

class PlatformRateRecordRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(PlatformRateRecord::class);
    }

    /**
     * 檢查指定平台及日期是否已有紀錄
     *
     * @param  integer $platformId
     * @param  string  $dateAt
     * @return integer
     */
    public function findByPlatformIdAndDate($platformId, $dateAt)
    {
        return PlatformRateRecord::select('id')
                                 ->platform($platformId)
                                 ->where('date_at', $dateAt)
                                 ->get()
                                 ->count();
    }
}
