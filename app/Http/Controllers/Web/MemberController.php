<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Web\MemberServices;

class MemberController extends Controller
{
    protected $memberSrv;

    public function __construct(MemberServices $memberSrv)
    {
        $this->memberSrv = $memberSrv;
    }

    /**
     * 會員導轉登入
     *
     * @param  Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function redirect(Request $request)
    {
        $result = $this->memberSrv->redirect($request->input('token', ''), get_real_ip($request->ip()));
        if (!$result['result']) {
            abort(404);
        }
        return redirect('/');
    }

    /**
     * 會員自動導轉登入
     *
     * @param  Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function autoRedirect(Request $request)
    {
        $result = $this->memberSrv->autoRedirect($request->input('platform', ''), $request->input('account', ''), get_real_ip($request->ip()));
        if (!$result['result']) {
            abort(404);
        }
        return redirect('/');
    }
}
