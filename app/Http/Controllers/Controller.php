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
        $userPermission = Cache::tags(['adminPermission'])->get($user['id']);
        $permission = [];
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
            'sidebarMenu' => $permission,
            'activePage'  => $nowPathKey,
            'titlePage'   => trans('custom.admin.func.' . $nowPathKey),
        ];
    }
}
