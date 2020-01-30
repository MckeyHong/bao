<?php

namespace App\Services\Common;

use Illuminate\Support\Str;
use App\Api\Traits\ApiCommonTraits;
use App\Api\Traits\Member\MemberCreditTraits;
use App\Api\Traits\Transfer\TransferCreditTraits;
use App\Repositories\Balance\BalanceTransferRepository;
use App\Repositories\Member\MemberRepository;

class TrasnferServices
{
    use ApiCommonTraits, MemberCreditTraits, TransferCreditTraits;

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
            if ($credit == 0) {
                throw new \Exception('要轉換的額度為0', 417);
            }
            $memberRepo = new MemberRepository();
            $member = $memberRepo->findWriteConnect($member['id']);
            $creditBefore = bcadd(($member['credit'] + $member['today_deposit']), $member['interest'], 8);
            if ($type == 'OUT') {
                if ($creditBefore < $credit) {
                    throw new \Exception('提領額度超過錢包', 417);
                }
                $creditAfter = bcsub($creditBefore, $credit, 8);
            } else {
                if ($this->getMemberCreditOfApi($member['account'])['data'] < $credit) {
                    throw new \Exception('平台额度不足', 417);
                }
                $creditAfter = bcadd($creditBefore, $credit, 8);
            }

            // 先將轉帳資料存到DB
            $this->setPlatformCode($member['platform_code']);
            $no = $this->getTransferNo();
            $balanceTransferRepo = new BalanceTransferRepository();
            $balanceTransfer = $balanceTransferRepo->store([
                'platform_id'   => $member['platform_id'],
                'member_id'     => $member['id'],
                'no'            => $no,
                'type'          => ($type == 'OUT') ? 2 : 1,
                'credit_before' => $creditBefore,
                'credit'        => $credit,
                'credit_after'  => $creditAfter,
            ]);
            // 執行轉帳
            $response = $this->transferCreditOfApi($member['account'], $no, $type, $credit);
            if ($response['result'] != config('custom.api.code.succcess')) {
                throw new \Exception('平台转帐异常', 417);
            }
            // 檢查轉帳狀態
            $response = $this->checkTransferCreditOfApi($no);
            if ($response['result'] != config('custom.api.code.succcess')) {
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
