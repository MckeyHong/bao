<?php

namespace App\Api\Traits\Transfer;

trait TransferCreditTraits
{
    /**
     * 會員數轉帳轉出入
     *
     * @param  string   $account   [會員帳號，Ex.PHLV162]
     * @param  string   $tradeNo   [轉帳交易單號]
     * @param  string   $type      [IN：轉入、OUT：轉出]
     * @param  integer  $credit    [要轉帳的額度]
     * @param  array    $extra     [額外參數]
     * @return array
     */
    public function transferCreditOfApi(string $account, string $tradeNo, string $type = 'IN', int $credit = 0, array $extra = [])
    {
        try {
            return [
                'result' => config('apiCode.code.succcess'),
                'data'   => true,
            ];
        } catch (\Exception $e) {
            return [
                'result' => $e->getCode() ?? config('apiCode.code.systemError'),
                'data'   => null,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 檢查轉帳是否正常
     *
     * @param  string   $tradeNo   [轉帳交易單號]
     * @param  array    $extra     [額外參數]
     * @return array
     */
    public function checkTransferCreditOfApi(string $tradeNo, array $extra = [])
    {
        try {
            return [
                'result' => config('apiCode.code.succcess'),
                'data'   => true,
            ];
        } catch (\Exception $e) {
            return [
                'result' => $e->getCode() ?? config('apiCode.code.systemError'),
                'data'   => null,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
