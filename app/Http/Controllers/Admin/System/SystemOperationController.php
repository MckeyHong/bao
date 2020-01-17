<?php

namespace App\Http\Controllers\Admin\System;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\System\SystemOperationServices;

class SystemOperationController extends Controller
{
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
        $dropdownSrv = new DropdownServices();
        $user = $dropdownSrv->dropdown('user');
        // 參數驗證
        $firstDay = Carbon::now()->subMonth(2)->toDateString() . ' 00:00';
        $defaultStartAt = Carbon::now()->toDateString() . ' 00:00';
        $defaultEndAt = Carbon::now()->toDateString() . ' 23:59';
        $params = [
            'start' => (validate_date($request->input('start', ''), 'Y-m-d H:i') && $request->input('start') >= $firstDay) ? $request->input('start') :  $defaultStartAt,
            'end'   => (validate_date($request->input('end', ''), 'Y-m-d H:i') && $request->input('end') >= $firstDay) ? $request->input('end') :  $defaultEndAt,
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
