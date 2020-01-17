<?php

namespace App\Api\Traits;

trait ApiCommonTraits
{
    public $platformCode;

    /**
     * 取得 PlatformCode
     *
     * @return string
     */
    public function getPlatformCode()
    {
        return $this->platformCode;
    }

    /**
     * 設置 PlatformCode
     *
     * @param string $platformCode
     */
    public function setPlatformCode($platformCode)
    {
        $this->platformCode = $platformCode;
    }

    /**
     * 取得對應的平台Services
     *
     * @return Services
     */
    public function getServices()
    {
        $platformCode = $this->getPlatformCode();
        $tmp = explode('_', $platformCode);
        $servicePath = 'App\Api\Services\\'. ucfirst($tmp[0]) . '\\' . ucwords(camel_case($platformCode)) . 'Services';
        return new $servicePath();
    }
}
