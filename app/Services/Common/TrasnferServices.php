<?php

namespace App\Services\Common;

use Illuminate\Support\Str;
use App\Api\Traits\ApiCommonTraits;
use App\Api\Traits\Transfer;
use App\Repositories\Balance\BalanceTransferRepository;

class TrasnferServices
{
    use ApiCommonTraits, Transfer;

    /**
     * 平台會員額度轉換
     *
     * @param  array   $member
     * @param  float   $credit
     * @param  string  $type
     * @return array
     */
    public function platform($member, $credit, $type = 'IN')
    {
        try {
            // 檢查額度是否大於0
            $credit = floatval($credit);
            if ($credit <= 0) {
                throw new \Exception('要轉換的額度為0', 417);
            }
            // 先將轉帳資料存到DB
            $this->setPlatformCode($member['platform_code']);
            $no = $this->getTransferNo();
            $balanceTransferRepo = new BalanceTransferRepository();
            $balanceTransfer = $balanceTransferRepo->store([
                'platform_id'   => $member['platform_id'],
                'member'        => $member['id'],
                'no'            => $no,
                'type'          => ($type == 'OUT') ? 2 : 1,
                'credit_before' => 0
                'credit'        => $credit,
                'credit_after'  => 0,
            ]);
            // 執行轉帳
            $response = $this->transferCreditOfApi($member['account'], $no, $type, $credit);
            if ($response['result'] != config('apiCode.code.succcess')) {
                throw new \Exception('平台转帐异常', 417);
            }
            // 檢查轉帳狀態
            $response = $this->checkTransferCreditOfApi($no);
            if ($response['result'] != config('apiCode.code.succcess')) {
                throw new \Exception('平台转帐核對异常', 417);
            }
            $balanceTransferRepo->update($balanceTransfer['id'], ['is_transfer' => 1]);

            return [
                'result' => true,
                'data'   => $balanceTransfer,
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'data'   => null,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 取得平台額度交易單號
     *
     * @return string
     */
    public function getTransferNo()
    {
        return Str::uuid();
    }
}
