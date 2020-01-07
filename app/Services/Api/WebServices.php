<?php

namespace App\Services\Api;

use Auth;
use App\Services\Common\InterestServices;
use App\Services\Common\RateServices;
use App\Repositories\Member\MemberTransferRepository;

class WebServices
{
    protected $interestSrv;
    protected $rateSrv;
    protected $memberTransferRepo;

    public function __construct(
        InterestServices $interestSrv,
        RateServices $rateSrv,
        MemberTransferRepository $memberTransferRepo
    ) {
        $this->interestSrv        = $interestSrv;
        $this->rateSrv            = $rateSrv;
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
}
