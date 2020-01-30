<?php

namespace App\Api\Traits\Wager;

trait WagerBetTotalTraits
{
    /**
     * 取得平台會員洗碼量
     *
     * @param  string  $date
     * @return array
     */
    public function getBetTotalOfApi($date, array $extra = [])
    {
        try {
            return [
                'result' => config('apiCode.code.succcess'),
                'data'   => [
                    ['account' => 'FF1688', 'bet_total' => 1000],
                    ['account' => 'DD888', 'bet_total' => 2000],
                ],
            ];
        } catch (\Exception $e) {
            return [
                'result' => $e->getCode() ?? config('apiCode.code.systemError'),
                'data'   => [],
                'error'  => $e->getMessage(),
            ];
        }
    }
}
