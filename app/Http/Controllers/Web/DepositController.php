<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepositController extends Controller
{
    /**
     * 立即存入
     *
     * @param  Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function index(Request $request)
    {
        return view('web.deposit');
    }
}
