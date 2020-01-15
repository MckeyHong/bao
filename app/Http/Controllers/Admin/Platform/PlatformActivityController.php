<?php

namespace App\Http\Controllers\Admin\Platform;

use Carbon\Carbon;
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
     * 新增資料
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        // 參數驗證
        $error = $request->validate([
            'platform_id' => 'required|exists:platforms,id',
            'start_at'    => 'required|date_format:Y-m-d|after_or_equal:' . Carbon::now()->toDateString(),
            'end_at'      => 'required|date_format:Y-m-d|after_or_equal:start_at',
            'rate'        => 'required|min:1|max:1000',
            'active'      => 'required|in:1,2',
        ]);
        $request['activity_id'] = 0;
        $this->buildActivityValidation();
        $error = $request->validate([
            'activity_id' => 'required|non_exists:' . $request->input('platform_id')  . ',' . $request->input('start_at') . ',' . $request->input('end_at'),
        ]);

        // 執行結果
        $result = $this->platformActivitySrv->store($request->all());
        $this->setExecuteResult($result['result'], 'store');
        return redirect('/ctl/platform/activity');
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
        $request['activity_id'] = $id;
        $validator = Validator::make($request->all(), [
            'activity_id' => 'required|exists:platform_activity_rate,id',
        ]);
        if ($validator->fails()) {
            abort(404);
        }
        $dropdownSrv = new DropdownServices();
        return view('admin.platform.activityEdit', array_merge($this->adminResponse(), [
            'platform' => $dropdownSrv->dropdown('platform'),
            'detail'   => $this->platformActivitySrv->getEdit($id)['data'],
        ]));
    }

    /**
     * 新增資料
     *
     * @param \Illuminate\Http\Request  $request
     * @param  inteeger                 $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Request $request, $id)
    {
        // 參數驗證
        $request['activity_id'] = $id;
        $error = $request->validate([
            'platform_id' => 'required|exists:platforms,id',
            'start_at'    => 'required|date_format:Y-m-d|after_or_equal:' . Carbon::now()->toDateString(),
            'end_at'      => 'required|date_format:Y-m-d|after_or_equal:start_at',
            'rate'        => 'required|min:1|max:1000',
            'active'      => 'required|in:1,2',
        ]);
        $this->buildActivityValidation();
        $error = $request->validate(['activity_id' => 'required|exists:platform_activity_rate,id|non_exists:' . $request->input('platform_id')  . ',' . $request->input('start_at') . ',' . $request->input('end_at')]);

        // 執行結果
        $result = $this->platformActivitySrv->edit($id, $request->all());
        $this->setExecuteResult($result['result'], 'edit');
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

    /**
     * 新增清單頁面
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Blade
     */
    public function getStore(Request $request)
    {
        $dropdownSrv = new DropdownServices();
        return view('admin.platform.activityCreate', array_merge($this->adminResponse(), [
            'platform' => $dropdownSrv->dropdown('platform')
        ]));
    }

    /**
     * 平台活動重複檢查
     *
     */
    public function buildActivityValidation()
    {
        Validator::extend('non_exists', function ($attribute, $value, $parameters, $validator) {
            return $this->platformActivitySrv->checkActivityExists($value, $parameters[0], $parameters[1], $parameters[2]);
        });
    }
}
