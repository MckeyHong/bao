<?php

namespace App\Http\Controllers\Admin\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\TimeTraits;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\Report\ReportInterestServices;

class ReportInterestController extends Controller
{
    use TimeTraits;

    protected $reportInterestSrv;

    public function __construct(
        ReportInterestServices $reportInterestSrv
    ) {
        $this->reportInterestSrv = $reportInterestSrv;
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

        return view('admin.report.interest', array_merge($this->adminResponse(), [
            'get'      => $params,
            'platform' => $platform,
            'lists'    => $this->reportInterestSrv->index($params, $platform)['data'],
            'firstDay' => Carbon::now()->subMonth(6)->toDateString(),
        ]));
    }

    /**
     * 明細清單
     *
     * @param \Illuminate\Http\Request  $request
     * @param integer                   $platformId
     * @return \Illuminate\Support\Facades\Blade
     */
    public function detail(Request $request, $platformId)
    {
        // 參數驗證
        $dropdownSrv = new DropdownServices();
        $platform = $dropdownSrv->dropdown('platform');
        if (!in_array($platformId, array_keys($platform))) {
            abort(404);
        }
        $params = $this->handleGetParameters($request, $platform);
        return view('admin.report.interestDetail', array_merge($this->adminResponse(), [
            'get'      => $params,
            'goBack'   => asset('ctl/report/interest') .'?'. http_build_query($params),
            'platform' => $platform[$platformId],
            'lists'    => $this->reportInterestSrv->detail($platformId, $params)['data'],
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
        ];
        $params['start'] = ($params['start'] > $params['end']) ? $params['end'] : $params['start'];
        return $params;
    }
}
