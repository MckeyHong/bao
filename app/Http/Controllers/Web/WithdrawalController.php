<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\CommonTraits;

class WithdrawalController extends Controller
{
    use CommonTraits;

    /**
     * 立即提領
     *
     * @param  Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function index(Request $request)
    {
        return view('web.withdrawal', array_merge($this->webResponse(), [
            'workable' => $this->checkWorkable(),
        ]));
    }
}
