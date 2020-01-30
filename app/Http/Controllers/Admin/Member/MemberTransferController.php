<?php

namespace App\Http\Controllers\Admin\Member;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\TimeTraits;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\Member\MemberTransferServices;

class MemberTransferController extends Controller
{
    use TimeTraits;

    protected $memberTransferSrv;

    public function __construct(
        MemberTransferServices $memberTransferSrv
    ) {
        $this->memberTransferSrv = $memberTransferSrv;
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
        $today = Carbon::now()->toDateString();
        $firstDay = Carbon::now()->subMonth(2)->toDateString() . ' 00:00';
        $params = [
            'start'    => $this->validateAdminDateTime($request->input('start', ''), $firstDay, $today . ' 00:00'),
            'end'      => $this->validateAdminDateTime($request->input('end', ''), $firstDay, $today . ' 23:59'),
            'platform' => (in_array($request->input('platform'), array_keys($platform))) ? $request->input('platform') : 0,
            'account'  => $request->input('account', ''),
        ];
        $params['start'] = ($params['start'] > $params['end']) ? $params['end'] : $params['start'];

        return view('admin.member.transfer', array_merge($this->adminResponse(), [
            'get'      => $params,
            'platform' => $platform,
            'lists'    => $this->memberTransferSrv->index($params, $platform)['data'],
            'firstDay' =>$firstDay,
        ]));
    }
}
