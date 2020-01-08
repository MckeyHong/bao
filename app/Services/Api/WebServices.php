<?php

namespace App\Services\Api;

use Auth;
use App\Services\Common\InterestServices;
use App\Services\Common\RateServices;
use App\Services\Web\RecordServices;
use App\Repositories\Member\MemberTransferRepository;

class WebServices
{
    protected $interestSrv;
    protected $rateSrv;
    protected $recordSrv;
    protected $memberTransferRepo;

    public function __construct(
        InterestServices $interestSrv,
        RateServices $rateSrv,
        RecordServices $recordSrv,
        MemberTransferRepository $memberTransferRepo
    ) {
        $this->interestSrv        = $interestSrv;
        $this->rateSrv            = $rateSrv;
        $this->recordSrv          = $recordSrv;
        $this->memberTransferRepo = $memberTransferRepo;
    }

    /**
     * 立即存入
     *
     * @param  array. $memberId
     * @return array
     */
    public function deposit($request)
    {
        try {
            $data = [];
            return [
                'result' => true,
                'data'   => $data,
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 一鍵提領
     *
     * @param  array. $memberId
     * @return array
     */
    public function withdrawal($request)
    {
        try {
            $data = [];
            return [
                'result' => true,
                'data'   => $data,
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 歷程查詢
     *
     * @param  array. $memberId
     * @return array
     */
    public function record($request)
    {
        try {
            $member = Auth::guard('api')->user();
            $record = $this->recordSrv->getRecordList($member['id'], $request['start'], $request['end']);
            $total = 0;
            if ($request['page'] == 1) {
                $total = $this->recordSrv->getRecordTotal($member['id'], $request['start'], $request['end']);
            }
            return [
                'code'   => 200,
                'result' => [
                    'more'  => $record->hasMorePages(),
                    'list'  => $record,
                    'total' => $total,
                ],
            ];
        } catch (\Exception $e) {
            return [
                'code'   => $e->getCode() ?? 500,
                'result' => [],
                'error'  => $e->getMessage(),
            ];
        }
    }
}
