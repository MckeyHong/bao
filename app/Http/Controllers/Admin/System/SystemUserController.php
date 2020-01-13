<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\System\SystemUserServices;

class SystemUserController extends Controller
{
    protected $systemUserSrv;

    public function __construct(
        SystemUserServices $systemUserSrv
    ) {
        $this->systemUserSrv = $systemUserSrv;
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
        $role = $dropdownSrv->dropdown('role');
        // 參數驗證
        $params = [
            'role'    => (in_array($request->input('role'), array_keys($role))) ? $request->input('role') : 0,
            'account' => $request->input('account', ''),
            'active'  => in_array($request->input('active'), [1, 2]) ? $request->input('active') : 0,
        ];

        return view('admin.system.user', array_merge($this->adminResponse(), [
            'get'   => $params,
            'role'  => $role,
            'lists' => $this->systemUserSrv->index($params, $role)['data'],
        ]));
    }
}
