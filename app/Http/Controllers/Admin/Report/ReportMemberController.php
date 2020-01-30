<?php

namespace App\Http\Controllers\Admin\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\TimeTraits;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\Report\ReportMemberServices;

class ReportMemberController extends Controller
{
    use TimeTraits;

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
        $params = [
            'start'   => $this->validateAdminDateTime($request->input('start', ''), $firstDay, Carbon::now()->subDay(6)->toDateString(), 'Y-m-d'),
            'end'     => $this->validateAdminDateTime($request->input('end', ''), $firstDay, Carbon::now()->toDateString(), 'Y-m-d'),
            'platform' => (in_array($request->input('platform'), array_keys($platform))) ? $request->input('platform') : 0,
            'account'  => $request->input('account', ''),
        ];
        $params['start'] = ($params['start'] > $params['end']) ? $params['end'] : $params['start'];
        return $params;
    }
}
