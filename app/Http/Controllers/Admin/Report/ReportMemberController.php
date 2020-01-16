<?php

namespace App\Http\Controllers\Admin\Report;

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
        $dropdownSrv = new DropdownServices();
        $platform = $dropdownSrv->dropdown('platform');
        // 參數驗證
        $params = [
            'start'    => '',
            'end'      => '',
            'platform' => (in_array($request->input('platform'), array_keys($platform))) ? $request->input('platform') : 0,
            'account'  => $request->input('account', ''),
        ];

        return view('admin.report.member', array_merge($this->adminResponse(), [
            'get'      => $params,
            'platform' => $platform,
            'lists'    => $this->reportMemberSrv->index($params, $platform)['data'],
        ]));
    }
}
