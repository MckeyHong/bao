<?php

namespace App\Traits;

trait CommonTraits
{
    /**
     * 檢查目前是否可操作時間
     *
     * @return boolean    [true:可操作、false:不可操作]
     */
    public function checkWorkable()
    {
        try {
            $date = date('Y-m-d');
            return !(time() > strtotime($date . ' 00:00:00') && time() < strtotime($date . ' 00:10:00')) ?: false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
