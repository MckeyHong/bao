<?php

namespace App\Http\Controllers;

use Auth;
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
            $member['balance'] = amount_format($member['credit'] + $member['today_deposit'] + $member['interest']);
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
}
