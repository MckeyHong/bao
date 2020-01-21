<?php

namespace App\Http\Controllers\Admin\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\Report\ReportMemberServices;

class ReportMemberController extends Controller
{
    protected $reportMemberSrv;

    public function __construct(
        ReportMemberServices $reportMemberSrv
    ) {
        $this->reportMemberSrv = $reportMemberSrv;
    }

    /**
     * 列表清單
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Blade
     */
    public function index(Request $request)
    {
        // 參數驗證
        $dropdownSrv = new DropdownServices();
        $platform = $dropdownSrv->dropdown('platform');
        $params = $this->handleGetParameters($request, $platform);

        return view('admin.report.member', array_merge($this->adminResponse(), [
            'get'      => $params,
            'platform' => $platform,
            'lists'    => $this->reportMemberSrv->index($params, $platform)['data'],
            'firstDay' => Carbon::now()->subMonth(6)->toDateString(),
        ]));
    }

    /**
     * 處理 GET 參數
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array                     $platform
     * @return array
     */
    private function handleGetParameters($request, $platform)
    {
        $firstDay = Carbon::now()->subMonth(6)->toDateString();
        $defaultStartAt = Carbon::now()->subDay(6)->toDateString();
        $defaultEndAt = Carbon::now()->toDateString();
        $params = [
            'start'    => (validate_date($request->input('start', '')) && $request->input('start') >= $firstDay) ? $request->input('start') :  $defaultStartAt,
            'end'      => (validate_date($request->input('end', '')) && $request->input('end') >= $firstDay) ? $request->input('end') :  $defaultEndAt,
            'platform' => (in_array($request->input('platform'), array_keys($platform))) ? $request->input('platform') : 0,
            'account'  => $request->input('account', ''),
        ];
        $params['start'] = ($params['start'] > $params['end']) ? $params['end'] : $params['start'];
        return $params;
    }
}
