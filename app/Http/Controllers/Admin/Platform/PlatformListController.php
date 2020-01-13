<?php

namespace App\Http\Controllers\Admin\Platform;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\Platform\PlatformListServices;

class PlatformListController extends Controller
{
    protected $platformListSrv;

    public function __construct(
        PlatformListServices $platformListSrv
    ) {
        $this->platformListSrv = $platformListSrv;
    }

    /**
     * 列表清單
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('admin.platform.list', array_merge($this->adminResponse(), ['lists' => $this->platformListSrv->index()['data']]));
    }
}
