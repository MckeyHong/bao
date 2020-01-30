<?php

namespace App\Http\Controllers\Admin\System;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\TimeTraits;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\System\SystemOperationServices;

class SystemOperationController extends Controller
{
    use TimeTraits;

    protected $systemOperationSrv;

    public function __construct(
        SystemOperationServices $systemOperationSrv
    ) {
        $this->systemOperationSrv = $systemOperationSrv;
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
        $user = $dropdownSrv->dropdown('user');
        $today = Carbon::now()->toDateString();
        $firstDay = Carbon::now()->subMonth(2)->toDateString() . ' 00:00';
        $params = [
            'start' => $this->validateAdminDateTime($request->input('start', ''), $firstDay, $today . ' 00:00'),
            'end'   => $this->validateAdminDateTime($request->input('end', ''), $firstDay, $today . ' 23:59'),
            'func'  => $request->input('func', ''),
            'user'  => (in_array($request->input('user'), array_keys($user))) ? $request->input('user') : 0,
        ];
        $params['start'] = ($params['start'] > $params['end']) ? $params['end'] : $params['start'];

        return view('admin.system.operation', array_merge($this->adminResponse(), [
            'user'     => $user,
            'get'      => $params,
            'lists'    => $this->systemOperationSrv->index($params)['data'],
            'firstDay' => $firstDay,
        ]));
    }

    /**
     * 單筆歷程資料
     *
     * @param \Illuminate\Http\Request  $request
     * @param string  $funcKey
     * @param string  $funcId
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function detail(Request $request, $funcKey, $funcId)
    {
        return $this->apiResponse($this->systemOperationSrv->detail($funcKey, $funcId));
    }
}
