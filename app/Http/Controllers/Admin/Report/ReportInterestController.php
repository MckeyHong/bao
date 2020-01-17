<?php

namespace App\Http\Controllers\Admin\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\Report\ReportInterestServices;

class ReportInterestController extends Controller
{
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
        $firstDay = Carbon::now()->subMonth(6)->toDateString();
        $defaultStartAt = Carbon::now()->subDay(6)->toDateString();
        $defaultEndAt = Carbon::now()->toDateString();
        $params = [
            'start'    => (validate_date($request->input('start', '')) && $request->input('start') >= $firstDay) ? $request->input('start') :  $defaultStartAt,
            'end'      => (validate_date($request->input('end', '')) && $request->input('end') >= $firstDay) ? $request->input('end') :  $defaultEndAt,
            'platform' => (in_array($request->input('platform'), array_keys($platform))) ? $request->input('platform') : 0,
        ];
        $params['start'] = ($params['start'] > $params['end']) ? $params['end'] : $params['start'];

        return view('admin.report.interest', array_merge($this->adminResponse(), [
            'get'      => $params,
            'platform' => $platform,
            'lists'    => $this->reportInterestSrv->index($params, $platform)['data'],
            'firstDay' => $firstDay,
        ]));
    }
}
