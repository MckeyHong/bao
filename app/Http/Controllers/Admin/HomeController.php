<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\HomeServices;

class HomeController extends Controller
{
    protected $homeSrv;

    public function __construct(
        HomeServices $homeSrv
    ) {
        $this->homeSrv = $homeSrv;
    }

    /**
     * 列表清單
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Facades\Blade
     */
    public function index(Request $request)
    {
        return view('admin.dashboard', array_merge($this->adminResponse(), [
            'lists' => $this->homeSrv->index()['data'],
        ]));
    }
}
