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
        $dropdownSrv = new DropdownServices();
        $platform = $dropdownSrv->getPlatform();
        $firstDay = Carbon::now()->subMonth(2)->toDateString();
        $today = Carbon::now()->toDateString();
        // 參數驗證
        $params = [
            'start'    => (validate_date($request->input('start', '')) && $request->input('start') <= $today && $request->input('start') >= $firstDay) ? $request->input('start') : $today,
            'end'      => (validate_date($request->input('end', '')) && $request->input('end') <= $today && $request->input('end') >= $firstDay) ? $request->input('end') : $today,
            'platform' => (in_array($request->input('platform'), array_keys($platform))) ? $request->input('platform') : 0,
            'account'  => $request->input('account', ''),
            'status'   => in_array($request->input('status'), [1, 2]) ? $request->input('status') : 0,
        ];

        $params['start'] = ($params['start'] > $params['end']) ? $params['end'] : $params['start'];
        $params['start'] = $this->covertUTC8ToUTC($params['start'] . ' 00:00:00');
        $params['end'] = $this->covertUTC8ToUTC($params['end'] . ' 23:59:59');

        return view('admin.member.login', array_merge($this->adminResponse(), [
            'get'      => $params,
            'platform' => $platform,
            'lists'    => $this->memberLoginSrv->index($params, $platform)['data'],
        ]));
    }
}
