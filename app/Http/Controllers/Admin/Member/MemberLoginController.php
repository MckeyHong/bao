<?php

namespace App\Http\Controllers\Admin\Member;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\Member\MemberLoginServices;

class MemberLoginController extends Controller
{
    protected $memberLoginSrv;

    public function __construct(
        MemberLoginServices $memberLoginSrv
    ) {
        $this->memberLoginSrv = $memberLoginSrv;
    }

    /**
     * 列表清單
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $dropdownSrv = new DropdownServices();
        $platform = $dropdownSrv->dropdown('platform');
        // 參數驗證
        $firstDay = Carbon::now()->subMonth(2)->toDateString() . ' 00:00';
        $defaultStartAt = Carbon::now()->toDateString() . ' 00:00';
        $defaultEndAt = Carbon::now()->toDateString() . ' 23:59';
        $params = [
            'start'   => (validate_date($request->input('start', ''), 'Y-m-d H:i') && $request->input('start') >= $firstDay) ? $request->input('start') :  $defaultStartAt,
            'end'     => (validate_date($request->input('end', ''), 'Y-m-d H:i') && $request->input('end') >= $firstDay) ? $request->input('end') :  $defaultEndAt,
            'platform' => (in_array($request->input('platform'), array_keys($platform))) ? $request->input('platform') : 0,
            'account'  => $request->input('account', ''),
            'status'   => in_array($request->input('status'), [1, 2]) ? $request->input('status') : 0,
        ];
        $params['start'] = ($params['start'] > $params['end']) ? $params['end'] : $params['start'];

        return view('admin.member.login', array_merge($this->adminResponse(), [
            'get'      => $params,
            'platform' => $platform,
            'lists'    => $this->memberLoginSrv->index($params, $platform)['data'],
            'firstDay' => $firstDay,
        ]));
    }
}
