<?php

namespace App\Http\Controllers\Admin\System;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Admin\System\SystemProfileServices;

class SystemProfileController extends Controller
{
    protected $systemProfileSrv;

    public function __construct(
        SystemProfileServices $systemProfileSrv
    ) {
        $this->systemProfileSrv = $systemProfileSrv;
    }

    /**
     * 列表清單頁面
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Blade
     */
    public function index(Request $request)
    {
        return view('admin.system.profile', array_merge(array_merge($this->adminResponse(), $this->getExecuteResult()), [
            'lists' => $this->systemProfileSrv->index()['data'],
        ]));
    }

    /**
     * 編輯資料
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Blade
     */
    public function edit(Request $request)
    {
        // 參數驗證
        Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
            return $this->systemProfileSrv->checkOldPasswordExists($value);
        });
        $request->validate([
            'old_password' => 'required|min:6|max:20|old_password',
            'password'     => 'required|confirmed|min:6|max:20',
        ]);

        // 執行結果
        $result = $this->systemProfileSrv->edit($request);
        $this->setExecuteResult($result['result'], 'edit');
        return redirect('/ctl/home');
    }
}
