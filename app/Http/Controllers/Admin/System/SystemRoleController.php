<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Admin\System\SystemRoleServices;

class SystemRoleController extends Controller
{
    const LIST_PATH = '/ctl/system/role';

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
            'permission' => 'required|array',
        ]);

        // 執行結果
        $result = $this->systemRoleSrv->store($request->all());
        $this->setExecuteResult($result['result'], 'store');
        return redirect(self::LIST_PATH);
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
            'id' => 'required|exists:roles,id',
        ]);
        if ($validator->fails()) {
            abort(404);
        }

        return view('admin.system.roleEdit', array_merge($this->adminResponse(), [
            'detail' => $this->systemRoleSrv->getEdit($id)['data'],
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
        $request['role_id'] = $id;
        $request->validate([
            'role_id'    => 'required|exists:roles,id',
            'name'       => 'required|max:20',
            'active'     => 'required|in:1,2',
            'permission' => 'required|array',
        ]);
        // 執行結果
        $result = $this->systemRoleSrv->edit($id, $request->all());
        $this->setExecuteResult($result['result'], 'edit');
        return redirect(self::LIST_PATH);
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
        $request['role_id'] = $id;
        $error = $request->validate(['role_id' => 'required|exists:roles,id']);

        // 執行結果
        $result = $this->systemRoleSrv->destroy($id);
        $this->setExecuteResult($result['result'], 'destroy');
        return redirect(self::LIST_PATH);
    }
}
