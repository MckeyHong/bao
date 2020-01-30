<?php

namespace App\Http\Controllers\Admin\Member;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\TimeTraits;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\Member\MemberLoginServices;

class MemberLoginController extends Controller
{
    use TimeTraits;

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
        // 參數驗證
        $dropdownSrv = new DropdownServices();
        $platform = $dropdownSrv->dropdown('platform');
        $today = Carbon::now()->toDateString();
        $firstDay = Carbon::now()->subMonth(2)->toDateString() . ' 00:00';
        $params = [
            'start'    => $this->validateAdminDateTime($request->input('start', ''), $firstDay, $today . ' 00:00'),
            'end'      => $this->validateAdminDateTime($request->input('end', ''), $firstDay, $today . ' 23:59'),
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
