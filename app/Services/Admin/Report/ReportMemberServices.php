<?php

namespace App\Services\Admin\Report;

class ReportMemberServices
{
    /**
     * 取得列表清單
     *
     * @param  array    $params
     * @param  array    $platform
     * @return array
     */
    public function index($params, $platform)
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
                'data'   => [],
                'error'  => $e->getMessage(),
            ];
        }
    }
}
