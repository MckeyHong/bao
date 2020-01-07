<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Web\HomeServices;

class HomeController extends Controller
{
    protected $homeSrv;

    public function __construct(
        HomeServices $homeSrv
    ) {
        $this->homeSrv = $homeSrv;
    }

    /**
     * 首頁
     *
     * @param  Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function index(Request $request)
    {
        return view('web.home', array_merge($this->webResponse(), $this->homeSrv->index()['data']));
    }
}
