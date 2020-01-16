<?php

namespace App\Http\Controllers;

use Auth;
use Cache;
use Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Api\Traits\Member\MemberCreditTraits;
use App\Repositories\Role\RolePermissionRepository;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, MemberCreditTraits;

    /**
     * 會員端共用參數
     *
     * @return array
     */
    public function webResponse()
    {
        $member = [];
        if (Auth::guard('web')->check()) {
            $member = Auth::guard('web')->user();
            $member['balance'] = bcadd(($member['credit'] + $member['today_deposit']), $member['interest'], 2);
            $member['platform_credit'] = $this->getMemberCreditOfApi($member['account'])['data'];
        }

        $path = Request::path();
        $browserTitle = trans('custom.web.func.' . $path);
        return [
            'member'       => $member,
            'path'         => $path,
            'browserTitle' => ($browserTitle != '') ? $browserTitle . ' - ' : '',
        ];
    }

    /**
     * API回傳格式處理
     *
     * @param  array $response
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function apiResponse($response)
    {
        return response()->json(['result' => $response['result'] ?? true], $response['code'] ?? 500);
    }

    /**
     * 后台共用參數
     *
     * @return array
     */
    public function adminResponse()
    {
        $user = Auth::guard('user')->user();
        $path = explode('/', Request::path());
        $nowPathKey = ($path[1] ?? '').ucfirst($path[2] ?? '');
        // 依帳號角色功能權限調整功能顯示清單
        $activePath = '/ctl/home';
        $permission = [];
        $userPermission = Cache::tags(['adminPermission', $user['role_id']])->get($user['id']);
        if ($userPermission == null) {
            $userPermission = [];
            $repo = new RolePermissionRepository();
            $tmp = $repo->getListByRoleId($user['role_id']);
            foreach ($tmp as $value) {
                $value = $value->toArray();
                $userPermission[$value['path']] = $value;
            }
            Cache::tags(['adminPermission', $user['role_id']])->put($user['id'], $userPermission, 1440);
        }
        foreach (config('permission.func') as $cate) {
            $cate['active'] = $cate['aria'] = $cate['show'] = '';
            $tmpMenu = [];
            foreach ($cate['menu'] as $menu) {
                $menu['active'] = '';
                if ($nowPathKey == $menu['key']) {
                    $cate['active'] = 'active';
                    $cate['aria'] = 'true';
                    $cate['show'] = 'show';
                    $menu['active'] = 'active';
                    $activePath = $menu['path'];
                }
                if (($userPermission[$menu['path']]['is_get'] ?? 2) == 1) {
                    $tmpMenu[] = $menu;
                }
            }
            if (count($tmpMenu) > 0) {
                $cate['menu'] = $tmpMenu;
                $permission[] = $cate;
            }
        }

        return [
            'sidebarMenu'      => $permission,
            'activePage'       => $nowPathKey,
            'activePath'       => $activePath,
            'activeUrl'        => asset($activePath),
            'titlePage'        => trans('custom.admin.func.' . $nowPathKey),
            'actionPermission' => $userPermission[$activePath] ?? ['is_get' => 2, 'is_post' => 2, 'is_put' => 2, 'is_delete' => 2],
        ];
    }

    /**
     * 設定操作的執行結果
     *
     * @param string  $execute
     * @param string  $head
     * @return array
     */
    public function setExecuteResult($execute, $head)
    {
        if ($execute) {
            $result = 'success';
            $message = trans('custom.admin.result.' . $head . 'Success');
        } else {
            $result = 'danger';
            $message = trans('custom.admin.result.' . $head . 'False');
        }
        Cache::put('executeResult', $result, 5);
        Cache::put('executeMessage', $message, 5);
    }

    /**
     * 取得設定操作的執行結果
     *
     * @return array
     */
    public function getExecuteResult()
    {
        $executeResult = $executeMessage = '';
        if (Cache::has('executeResult')) {
            $executeResult = Cache::get('executeResult');
            $executeMessage = Cache::get('executeMessage');
            Cache::forget('executeResult');
            Cache::forget('executeMessage');
        }

        return [
            'executeResult'  => $executeResult,
            'executeMessage' => $executeMessage,
        ];
    }
}
