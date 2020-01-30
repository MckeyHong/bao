<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Api\ApiServices;

class MemberController extends Controller
{
    protected $apiSrv;

    public function __construct(
        ApiServices $apiSrv
    ) {
        $this->apiSrv = $apiSrv;
    }

    /**
     * 會員登入導轉
     *
     * @param  Request $request
     * @return Illuminate\Support\Facades\View
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api.account' => 'required',
            'api.time'    => config('custom.api.time'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'data'   => null,
                'error'  => 'Validation Error',
            ], 422);
        }

        $response = $this->apiSrv->login($request->all());
        return response()->json([
            'result' => $response['result'],
            'data'   => $response['data'],
            'error'  => $response['error'],
        ], $response['code']);
    }
}
