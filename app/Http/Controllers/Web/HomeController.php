<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * 首頁
     *
     * @param  Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function index(Request $request)
    {
        return view('web.home');
    }
}
