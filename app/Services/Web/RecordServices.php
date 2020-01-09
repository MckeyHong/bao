<?php

namespace App\Services\Web;

use App\Traits\TimeTraits;
use App\Repositories\Member\MemberTransferRepository;

class RecordServices
{
    use TimeTraits;

    const TYPE_LIST = [
        '1' => '转入',
        '2' => '转出',
        '3' => '系统结算',
        '4' => '系统转出',
    ];

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
            $startAt = $this->covertUTC8ToUTC($startAt);
            $endAt = $this->covertUTC8ToUTC($endAt);
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
            $startAt = $this->covertUTC8ToUTC($startAt);
            $endAt = $this->covertUTC8ToUTC($endAt);
            $record = $this->memberTransferRepo->getMemberRecordList($memberId, $startAt, $endAt);
            foreach ($record as $value) {
                $value['created_at'] = $this->covertUTCToUTC8($value['created_at']);
                foreach (['credit_before', 'credit_after', 'credit'] as $field) {
                    $value[$field] = amount_format($value[$field], 2);
                }
                $value['interest'] = amount_format($value['interest'], 8);
                $value['class'] = (in_array($value['type'], [1, 3])) ? 'text-success' : 'text-danger';
                $value['type'] = self::TYPE_LIST[$value['type']];
            }
            return $record;
        } catch (\Exception $e) {
            return [];
        }
    }
}
