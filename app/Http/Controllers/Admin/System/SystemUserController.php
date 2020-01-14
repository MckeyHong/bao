<?php

namespace App\Http\Controllers\Admin\System;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
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
     * 列表清單頁面
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Blade
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

        return view('admin.system.user', array_merge(array_merge($this->adminResponse(), $this->getExecuteResult()), [
            'get'   => $params,
            'role'  => $role,
            'lists' => $this->systemUserSrv->index($params, $role)['data'],
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
        $dropdownSrv = new DropdownServices();
        $role = $dropdownSrv->dropdown('role');
        return view('admin.system.userCreate', array_merge($this->adminResponse(), ['role' => $role]));
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
        $this->buildAccountValidation();
        $error = $request->validate([
            'role_id'  => 'required|exists:roles,id',
            'account'  => 'required|min:4|max:30|non_exists:0',
            'password' => 'required|password|min:6|max:20',
            'name'     => 'required|max:30',
            'active'   => 'required|in:1,2',
        ]);
        // 執行結果
        $result = $this->systemUserSrv->store($request->all());
        $this->setExecuteResult($result['result'], 'store');
        return redirect('/ctl/system/user');
    }

    /**
     * 編輯資料頁面
     *
     * @param \Illuminate\Http\Request  $request
     * @param  inteeger                 $id
     * @return \Illuminate\Support\Facades\Blade
     */
    public function getEdit(Request $request, $id)
    {
        $request['id'] = $id;
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            abort(404);
        }
        $dropdownSrv = new DropdownServices();
        $role = $dropdownSrv->dropdown('role');
        return view('admin.system.userEdit', array_merge($this->adminResponse(), [
            'role'   => $role,
            'detail' => $this->systemUserSrv->getEdit($id)['data'],
        ]));
    }

    /**
     * 編輯資料
     *
     * @param \Illuminate\Http\Request  $request
     * @param  inteeger                 $id
     * @return \Illuminate\Support\Facades\Blade
     */
    public function edit(Request $request, $id)
    {
        // 參數驗證
        $request['user_id'] = $id;
        $params = [
            'user_id'  => 'required|exists:users,id',
            'role_id'  => 'required|exists:roles,id',
            'name'     => 'required|max:30',
            'active'   => 'required|in:1,2',
        ];
        if ($request->input('password', '') !== '' && $request->input('password', '') !== null) {
            $params['password'] = 'password|min:6|max:20';
        }
        $request->validate($params);

        // 執行結果
        $result = $this->systemUserSrv->edit($id, $request->all());
        $this->setExecuteResult($result['result'], 'edit');
        return redirect('/ctl/system/user');
    }

    /**
     * 刪除資料
     *
     * @param \Illuminate\Http\Request  $request
     * @param  inteeger                 $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy(Request $request, $id)
    {
        $request['user_id'] = $id;
        $error = $request->validate(['user_id' => 'required|exists:users,id']);

        // 執行結果
        $result = $this->systemUserSrv->destroy($id);
        $this->setExecuteResult($result['result'], 'destroy');
        return redirect('/ctl/system/user');
    }

    /**
     * 建置帳號重複驗查詢
     *
     */
    public function buildAccountValidation()
    {
        Validator::extend('non_exists', function ($attribute, $value, $parameters, $validator) {
            return $this->systemUserSrv->checkAccountExists($value, $parameters[0]);
        });
    }
}
