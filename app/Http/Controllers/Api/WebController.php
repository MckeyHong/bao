<?php

namespace App\Http\Controllers\Api;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\WebServices;

class WebController extends Controller
{
    private $member;
    protected $webSrv;

    public function __construct(
        WebServices $webSrv
    ) {
        $this->member = Auth::guard('api')->user();
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
        $platformCredit = $this->getMemberCreditOfApi($this->member['account'])['data'];
        $canDeposit = $this->webSrv->getTodayBetTotal($this->member['id']) - $this->member['today_deposit'];
        $request->validate([
            'credit' => 'required|min:1|max:' . ($canDeposit > $platformCredit ? $platformCredit : $canDeposit),
        ]);
        return $this->apiResponse($this->webSrv->deposit($this->member, $request->input('credit')));
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
        // 參數驗證
        $firstDay = Carbon::now()->subMonth(2)->toDateString();
        $today = Carbon::now()->toDateString();
        $params = [
            'start' => (validate_date($request->input('start', '')) && $request->input('start') <= $today && $request->input('start') >= $firstDay) ? $request->input('start') : $today,
            'end'   => (validate_date($request->input('end', '')) && $request->input('end') <= $today && $request->input('end') >= $firstDay) ? $request->input('end') : $today,
            'page'  => $request->input('page', 1),
        ];
        $params['start'] = ($params['start'] > $params['end']) ? $params['end'] : $params['start'];
        $params['start'] = $params['start'] . ' 00:00:00';
        $params['end'] = $params['end'] . ' 23:59:59';

        return $this->apiResponse($this->webSrv->record($this->member, $params));
    }
}
