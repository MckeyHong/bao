<?php

namespace App\Http\Controllers\Admin\System;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\TimeTraits;
use App\Services\Admin\System\SystemLoginServices;

class SystemLoginController extends Controller
{
    use TimeTraits;

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
        $today = Carbon::now()->toDateString();
        $firstDay = Carbon::now()->subMonth(2)->toDateString() . ' 00:00';
        $params = [
            'start'   => $this->validateAdminDateTime($request->input('start', ''), $firstDay, $today . ' 00:00'),
            'end'     => $this->validateAdminDateTime($request->input('end', ''), $firstDay, $today . ' 23:59'),
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
