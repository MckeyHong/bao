<?php

namespace App\Http\Controllers\Admin\System;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\System\SystemLoginServices;

class SystemLoginController extends Controller
{
    protected $systemLoginSrv;

    public function __construct(
        SystemLoginServices $systemLoginSrv
    ) {
        $this->systemLoginSrv = $systemLoginSrv;
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
        $firstDay = Carbon::now()->subMonth(2)->toDateString() . ' 00:00';
        $defaultStartAt = Carbon::now()->toDateString() . ' 00:00';
        $defaultEndAt = Carbon::now()->toDateString() . ' 23:59';
        $params = [
            'start'   => (validate_date($request->input('start', ''), 'Y-m-d H:i') && $request->input('start') >= $firstDay) ? $request->input('start') :  $defaultStartAt,
            'end'     => (validate_date($request->input('end', ''), 'Y-m-d H:i') && $request->input('end') >= $firstDay) ? $request->input('end') :  $defaultEndAt,
            'account' => $request->input('account', ''),
            'status'  => in_array($request->input('status'), [1, 2, 3, 4]) ? $request->input('status') : 0,
        ];
        $params['start'] = ($params['start'] > $params['end']) ? $params['end'] : $params['start'];

        return view('admin.system.login', array_merge($this->adminResponse(), [
            'get'      => $params,
            'lists'    => $this->systemLoginSrv->index($params)['data'],
            'firstDay' => $firstDay,
        ]));
    }
}
