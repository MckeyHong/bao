<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\System\SystemRoleServices;

class SystemRoleController extends Controller
{
    protected $systemRoleSrv;

    public function __construct(
        SystemRoleServices $systemRoleSrv
    ) {
        $this->systemRoleSrv = $systemRoleSrv;
    }

    /**
     * 列表清單頁面
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Blade
     */
    public function index()
    {
        return view('admin.system.role', array_merge(array_merge($this->adminResponse(), $this->getExecuteResult()), [
            'lists' => $this->systemRoleSrv->index()['data'],
        ]));
    }

    /**
     * 新增清單頁面
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Blade
     */
    public function getStore(Request $request)
    {
        return view('admin.system.roleCreate', $this->adminResponse());
    }

    /**
     * 新增資料
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        // 參數驗證
        $error = $request->validate([
            'name'       => 'required|max:20',
            'active'     => 'required|in:1,2',
            'permission' => 'required',
        ]);

        // 執行結果
        $result = $this->systemRoleSrv->store($request->all());
        $this->setExecuteResult($result['result'], 'store');
        return redirect('/ctl/system/role');
    }
}
