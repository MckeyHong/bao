<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function webResponse()
    {
        $member = [];
        if (Auth::guard('web')->check()) {
            $member = Auth::guard('web')->user();
            foreach (['credit', 'today_deposit', 'interest'] as $field) {
                $member[$field] = floatval($member[$field]);
            }
            $member['balance'] = floatval($member['credit'] + $member['today_deposit'] + $member['interest']);
        }

        return [
            'member' => $member,
        ];
    }
}
