<?php

namespace App\Traits;

use Log;

trait LoggingTraits
{
    public $loggingStartAt;
    public $loggingChannel = 'daily';
    public $loggingType = 'info';
    public $loggingMessage = '';
    public $loggingParams = [];

    /**
     *　設置Logging開始執行時間
     */
    public function setLoggingStartAt()
    {
        $this->loggingStartAt = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
    }

    /**
     * 取置 Logging 型態
     *
     * @param string $type  [emergency, alert, critical, error, warning, notice, info and debug]
     */
    public function setLoggingType($type)
    {
        $this->loggingType = (in_array($type, ['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'])) ? $type : 'error';
    }

    /**
     * 取置 Logging  訊息
     *
     * @param string $message
     */
    public function setLoggingMessage($message)
    {
        $this->loggingMessage = $message;
    }

    /**
     * 取置 Logging 訊息數據
     *
     * @param array $params
     */
    public function setLoggingParams(array $params)
    {
        $this->loggingParams = $params;
    }

    /**
     * 取置 Logging 頻道
     *
     * @param string $channel
     */
    public function setLoggingChannel($channel)
    {
        $this->loggingChannel = $channel;
    }

    /**
     * [排程] Logging 寫入
     *
     * @return boolean
     */
    public function writeLogging()
    {
        try {
            $this->loggingParams = array_merge(['start' => $this->loggingStartAt], $this->loggingParams);
            Log::channel($this->loggingChannel)->{$this->loggingType}($this->loggingMessage, $this->loggingParams);
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
            return false;
        }
    }
}
