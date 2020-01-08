<?php

namespace App\Services\Web;

use App\Repositories\Member\MemberTransferRepository;

class RecordServices
{
    protected $memberTransferRepo;

    public function __construct(
        MemberTransferRepository $memberTransferRepo
    ) {
        $this->memberTransferRepo = $memberTransferRepo;
    }

    /**
     * 取得會員異動紀錄
     *
     * @param  integer. $memberId
     * @param  string   $startAt
     * @param  string   $endAt
     * @return array
     */
    public function index($memberId, $startAt, $endAt)
    {
        try {
            return [
                'result' => true,
                'data'   => [
                    'total' => $this->getRecordTotal($memberId, $startAt, $endAt),
                    'list'  => $this->getRecordList($memberId, $startAt, $endAt),
                ],
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'data'   => ['total' => 0, 'list' => []],
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 取得歷程查詢總計
     *
     * @param  integer. $memberId
     * @param  string   $startAt
     * @param  string   $endAt
     * @return float
     */
    public function getRecordTotal($memberId, $startAt, $endAt)
    {
        try {
            return amount_format($this->memberTransferRepo->getMemberRecordTotal($memberId, $startAt, $endAt), 2);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * 取得歷程查詢列表
     *
     * @param  integer. $memberId
     * @param  string   $startAt
     * @param  string   $endAt
     * @return array
     */
    public function getRecordList($memberId, $startAt, $endAt)
    {
        try {
            $record = $this->memberTransferRepo->getMemberRecordList($memberId, $startAt, $endAt);
            foreach ($record as $value) {
                foreach (['credit_before', 'credit_after', 'credit'] as $field) {
                    $value[$field] = amount_format($value[$field], 2);
                }
                $value['interest'] = amount_format($value['interest'], 8);
                $value['class'] = (in_array($value['type'], [1, 3])) ? 'text-success' : 'text-danger';
            }
            return $record;
        } catch (\Exception $e) {
            return [];
        }
    }
}
