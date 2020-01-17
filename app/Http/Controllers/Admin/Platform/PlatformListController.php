<?php

namespace App\Http\Controllers\Admin\Platform;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Admin\Platform\PlatformListServices;

class PlatformListController extends Controller
{
    protected $platformListSrv;

    public function __construct(
        PlatformListServices $platformListSrv
    ) {
        $this->platformListSrv = $platformListSrv;
    }

    /**
     * 列表清單頁面
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Blade
     */
    public function index(Request $request)
    {
        return view('admin.platform.list', array_merge(array_merge($this->adminResponse(), $this->getExecuteResult()),
            [
                'lists' => $this->platformListSrv->index()['data']
            ]
        ));
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
            'id' => 'required|exists:platforms,id',
        ]);
        if ($validator->fails()) {
            abort(404);
        }
        return view('admin.platform.listEdit', array_merge($this->adminResponse(), [
            'detail' => $this->platformListSrv->getEdit($id)['data'],
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
        $request['platform_id'] = $id;
        $request->validate([
            'platform_id' => 'required|exists:platforms,id',
            'name'        => 'required|max:30',
            'future'      => 'required|min:1|max:100',
            'active'      => 'required|in:1,2',
        ]);

        // 執行結果
        $result = $this->platformListSrv->edit($id, $request->all());
        $this->setExecuteResult($result['result'], 'edit');
        return redirect('/ctl/platform/list');
    }
}
