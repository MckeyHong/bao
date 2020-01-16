<?php

namespace App\Http\Controllers\Admin\Report;

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
        $dropdownSrv = new DropdownServices();
        $platform = $dropdownSrv->dropdown('platform');
        // 參數驗證
        $params = [
            'platform' => (in_array($request->input('platform'), array_keys($platform))) ? $request->input('platform') : 0,
            'account'  => $request->input('account', ''),
        ];

        return view('admin.report.interest', array_merge($this->adminResponse(), [
            'get'      => $params,
            'platform' => $platform,
            // 'lists'    => $this->memberListSrv->index($params, $platform)['data'],
        ]));
    }
}
