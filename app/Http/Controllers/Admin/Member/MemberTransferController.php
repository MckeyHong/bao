<?php

namespace App\Http\Controllers\Admin\Member;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\Member\MemberTransferServices;

class MemberTransferController extends Controller
{
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
        $firstDay = Carbon::now()->subMonth(2)->toDateString() . ' 00:00';
        $defaultStartAt = Carbon::now()->toDateString() . ' 00:00';
        $defaultEndAt = Carbon::now()->toDateString() . ' 23:59';
        $params = [
            'start'    => (validate_date($request->input('start'), 'Y-m-d H:i') && $request->input('start') >= $firstDay) ? $request->input('start') :  $defaultStartAt,
            'end'      => (validate_date($request->input('end'), 'Y-m-d H:i') && $request->input('end') >= $firstDay) ? $request->input('end') :  $defaultEndAt,
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
