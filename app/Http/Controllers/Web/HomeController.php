<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Common\RateServices;

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
        $srv = new RateServices();
        return view('web.home', array_merge($this->webResponse(), [
            'rate' => $srv->getPlatformRate(1)
        ]));
    }
}
