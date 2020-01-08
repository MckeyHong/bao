<?php

namespace App\Api\Traits\Member;

trait MemberCreditTraits
{
    /**
     * 取得會員遊戲點數
     *
     * @param  string   $account   [會員帳號，Ex.PHLV162]
     * @param  array    $extra     [額外參數]
     * @return array
     */
    public function getMemberCreditOfApi(string $account, array $extra = [])
    {
        try {
            return [
                'result' => config('apiCode.code.succcess'),
                'data'   => 5000,
            ];
        } catch (\Exception $e) {
            return [
                'result' => $e->getCode() ?? config('apiCode.code.systemError'),
                'data'   => 0,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
