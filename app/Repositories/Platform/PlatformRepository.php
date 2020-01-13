<?php

namespace App\Repositories\Platform;

use App\Entities\Platform\Platform;
use App\Repositories\Repository;

class PlatformRepository
{
    use Repository;

    public function __construct()
    {
        $this->setEntity(Platform::class);
    }

    /**
     * 利用平台APIKey及IP取得平台資訊
     *
     * @param  string $apiKey
     * @param  string $ip
     * @param  array  $field
     * @return mixed
     */
    public function findByApiKey($apiKey, $ip, $field = ['platforms.id', 'platforms.api_key', 'platforms.encrypt_key'])
    {
        return Platform::select($field)
                          ->leftjoin('platform_whitelist', 'platform_whitelist.platform_id', '=', 'platforms.id')
                          ->where('api_key', $apiKey)
                          ->where('ip', $ip)
                          ->first();
    }


    /**
     * [控端] 列表清單
     *
     * @return mixed
     */
    public function getAdminList()
    {
        return Platform::select(['id', 'name', 'present', 'future', 'active', 'created_at', 'updated_at'])
                        ->paginate(config('custom.admin.paginate'));
    }

    /**
     * 下拉選單
     *
     * @return mixed
     */
    public function dropdown()
    {
        return Platform::pluck('name', 'id');
    }
}
