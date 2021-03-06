<?php

namespace App\Http\Controllers\Admin\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\Member\MemberListServices;

class MemberListController extends Controller
{
    protected $memberListSrv;

    public function __construct(
        MemberListServices $memberListSrv
    ) {
        $this->memberListSrv = $memberListSrv;
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
            'platform' => (in_array($request->input('platform'), array_keys($platform))) ? $request->input('platform') : 0,
            'account'  => $request->input('account', ''),
            'status'   => in_array($request->input('status'), [1, 2]) ? $request->input('status') : 0,
        ];

        return view('admin.member.list', array_merge($this->adminResponse(), [
            'get'      => $params,
            'platform' => $platform,
            'lists'    => $this->memberListSrv->index($params, $platform)['data'],
        ]));
    }
}
