<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    /**
     * 會員登入導轉
     *
     * @param  Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function login(Request $request)
    {
        dd($request->all());
    }
}
