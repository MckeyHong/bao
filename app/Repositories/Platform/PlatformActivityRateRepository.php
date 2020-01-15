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

    /**
     * [控端] 列表清單
     *
     * @param  array   $params
     * @return mixed
     */
    public function getAdminList($params)
    {
        $query = PlatformActivityRate::select(['id', 'platform_id', 'start_at', 'end_at', 'rate', 'active']);

        if (isset($params['platform']) && $params['platform'] > 0) {
            $query = $query->platform($params['platform']);
        }
        if (isset($params['active']) && $params['active'] > 0) {
            $query = $query->active($params['active']);
        }

        switch (($params['type']) ?? 2) {
            case '1':
                $query = $query->where('end_at', '>', $params['now_at']);
                break;
            case '3':
                $query = $query->where('start_at', '<=', $params['now_at'])->where('end_at', '>=', $params['now_at']);
                break;
            default:
                $query = $query->where('start_at', '>', $params['now_at']);
        }


        return $query->paginate(config('custom.admin.paginate'));
    }
}
