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
            foreach (['credit', 'today_deposit', 'interest'] as $field) {
                $member[$field] = amount_format($member[$field]);
            }
            $member['platform_credit'] = amount_format($this->getMemberCreditOfApi($member['account'])['data'], 2);
        }

        $path = Request::path();
        $browserTitle = trans('custom.web.func.' . $path);
        return [
            'member'       => $member,
            'path'         => $path,
            'browserTitle' => ($browserTitle != '') ? $browserTitle . ' - ' : '',
        ];
    }
}
