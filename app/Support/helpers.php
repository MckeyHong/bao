<?php

if (!function_exists('amount_format')) {
    /**
     * 金額格式化
     *
     * @param  decimal  $number
     * @param  integer  $decimal
     * @return string
     */
    function amount_format($number, $decimal = 2)
    {
        if ($number > 0) {
            $number = ($decimal == 0) ? floor($number) : floor((string)($number * pow(10, $decimal))) / pow(10, $decimal);
        } else {
            $number = ($decimal == 0) ? ceil($number) : ceil((string)($number * pow(10, $decimal))) / pow(10, $decimal);
        }
        return number_format($number, $decimal);
    }
}

if (!function_exists('floor_format')) {
    /**
     * 無條件捨去取到小數第N位,小數位數不足補0
     *
     * @param  float    $number
     * @param  integer  $decimal
     * @return string
     */
    function floor_format($number, $decimal = 8)
    {
        if ($number > 0) {
            $number = ($decimal == 0) ? floor($number) : floor((string)($number * pow(10, $decimal))) / pow(10, $decimal);
        } else {
            $number = ($decimal == 0) ? ceil($number) : ceil((string)($number * pow(10, $decimal))) / pow(10, $decimal);
        }
        // 小數位數不足捕0
        return sprintf('%.' . $decimal . 'f', $number);
    }
}

if (!function_exists('get_real_ip')) {
    /**
     * 取得真實IP (避免取到CDN機器IP)
     *
     * @param  string  $ip
     * @return string
     */
    function get_real_ip($ip)
    {
        try {
            if (in_array(config('common.APP_ENV'), ['experience', 'production'])) {
                if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
                    $tmp = $_SERVER["HTTP_CLIENT_IP"];
                } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                    $tmp = $_SERVER["HTTP_X_FORWARDED_FOR"];
                } else {
                    $tmp = $_SERVER["REMOTE_ADDR"];
                }
                $tmp = explode(',', $tmp);
                $ip = trim($tmp[0]);
            }
            return $ip;
        } catch (\Exception $e) {
            return $ip;
        }
    }
}

if (!function_exists('validate_date')) {
    /**
     * 驗證日期是否正確
     *
     * @param  string $date    [要檢查的日期資料]
     * @param  string $format  [要檢查的日期格式，預設為 Y-m-d]
     * @return boolean
     */
    function validate_date($date, $format = 'Y-m-d')
    {
        $tmpDate = DateTime::createFromFormat($format, $date);
        return $tmpDate && $tmpDate->format($format) == $date;
    }
}
