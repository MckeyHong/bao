<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Web\RecordServices;

class RecordController extends Controller
{
    protected $recordSrv;

    public function __construct(
        RecordServices $recordSrv
    ) {
        $this->recordSrv = $recordSrv;
    }

    /**
     * 異動明細
     *
     * @param  Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function index(Request $request)
    {
        $info = $this->webResponse();
        $info['date'] = Carbon::now()->toDateString();
        $info['record'] = $this->recordSrv->getRecord($info['member']['id'], $info['date'] . ' 00:00:00', $info['date'] . ' 23:59:59')['data'];
        return view('web.record', $info);
    }
}
