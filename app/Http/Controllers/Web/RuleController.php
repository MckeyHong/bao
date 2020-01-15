<?php

namespace App\Http\Controllers\Web;

use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RuleController extends Controller
{
    /**
     * 規則說明
     *
     * @param  Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function index(Request $request)
    {
        return view('web.rule.' . App::getLocale(), $this->webResponse());
    }
}
