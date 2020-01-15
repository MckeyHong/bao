<?php

namespace App\Http\Controllers\Admin\Platform;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Admin\DropdownServices;
use App\Services\Admin\Platform\PlatformActivityServices;

class PlatformActivityController extends Controller
{
    protected $platformActivitySrv;

    public function __construct(
        PlatformActivityServices $platformActivitySrv
    ) {
        $this->platformActivitySrv = $platformActivitySrv;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $dropdownSrv = new DropdownServices();
        $platform = $dropdownSrv->dropdown('platform');
        // 參數驗證
        $params = [
            'platform' => (in_array($request->input('platform'), array_keys($platform))) ? $request->input('platform') : 0,
            'active'   => in_array($request->input('active'), [1, 2]) ? $request->input('active') : 0,
            'type'     => in_array($request->input('type'), [1, 2, 3]) ? $request->input('type') : 2,
        ];

        return view('admin.platform.activity', array_merge(array_merge($this->adminResponse(), $this->getExecuteResult()), [
            'get'      => $params,
            'platform' => $platform,
            'lists'    => $this->platformActivitySrv->index($params, $platform)['data'],
        ]));
        return view('admin.platform.activity', $this->adminResponse());
    }

    /**
     * 關閉資料
     *
     * @param \Illuminate\Http\Request  $request
     * @param  inteeger                 $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function close(Request $request, $id)
    {
        $request['activity_id'] = $id;
        $error = $request->validate(['activity_id' => 'required|exists:platform_activity_rate,id']);
        // 執行結果
        $result = $this->platformActivitySrv->close($id);
        $this->setExecuteResult($result['result'], 'close');
        return redirect('/ctl/platform/activity');
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
        $request['activity_id'] = $id;
        $error = $request->validate(['activity_id' => 'required|exists:platform_activity_rate,id']);
        // 執行結果
        $result = $this->platformActivitySrv->destroy($id);
        $this->setExecuteResult($result['result'], 'destroy');
        return redirect('/ctl/platform/activity');
    }
}
