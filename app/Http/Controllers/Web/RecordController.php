<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecordController extends Controller
{
    /**
     * 異動明細
     *
     * @param  Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function index(Request $request)
    {
        return view('web.record');
    }
}
