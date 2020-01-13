<?php

namespace App\Http\Controllers\Admin\Platform;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\Platform\PlatformListServices;

class PlatformListController extends Controller
{
    protected $platformListSrc;

    public function __construct(
        PlatformListServices $platformListSrc
    ) {
        $this->platformListSrc = $platformListSrc;
    }

    /**
     * 列表清單
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('admin.platform.list', array_merge($this->adminResponse(), ['lists' => $this->platformListSrc->index()['data']]));
    }
}
