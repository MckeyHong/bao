<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Repositories\Member\MemberRepository;

class ApiServices
{
    protected $memberRepo;

    public function __construct(
        MemberRepository $memberRepo
    ) {
        $this->memberRepo = $memberRepo;
    }

    /**
     * 取得可充值的上限
     *
     * @param  array  $request
     * @return array
     */
    public function login($request)
    {
        try {
            $account = $request['api']['account'];
            $token = Str::random(60);
            $member = $this->memberRepo->findByAccount($request['platform']['id'], $account);
            if ($member == null) {
                $member = $this->memberRepo->store([
                    'platform_id' => $request['platform']['id'],
                    'account'     => $account,
                    'password'    => Hash::make(config('custom.member.password')),
                    'name'        => $account,
                    'api_token'   => $token,
                ]);
            } else {
                $this->memberRepo->update($member['id'], ['api_token' => $token]);
            }
            return [
                'result' => true,
                'data'   => config('custom.api.domain') . '/redirect?token=' . $token,
                'error'  => null,
                'code'   => 200,
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'data'   => null,
                'error'  => $e->getMessage(),
                'code'   => 500,
            ];
        }
    }
}
