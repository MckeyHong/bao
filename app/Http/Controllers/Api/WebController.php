<?php

namespace App\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebController extends Controller
{
    /**
     * 取得歷程紀錄
     *
     * @param  Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function record(Request $request)
    {
        dd(Auth::guard('api')->user(), $request->all());
    }
}
