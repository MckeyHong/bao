<?php

namespace App\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\WebServices;

class WebController extends Controller
{
    protected $webSrv;

    public function __construct(
        WebServices $webSrv
    ) {
        $this->webSrv = $webSrv;
    }

    /**
     * 立即存入
     *
     * @param  Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function deposit(Request $request)
    {
        // todo ...
    }

    /**
     * 一鍵提領
     *
     * @param  Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function withdrawal(Request $request)
    {
        // todo ...
    }

    /**
     * 歷程紀錄
     *
     * @param  Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function record(Request $request)
    {
        // todo...
    }
}
