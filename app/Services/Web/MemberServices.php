<?php

namespace App\Services\Web;

use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\Web\MemberLoginServices;
use App\Repositories\Member\MemberRepository;
use App\Repositories\Platform\PlatformRepository;

class MemberServices
{
    protected $memberLoginSrv;
    protected $memberRepo;
    protected $platformRepo;

    public function __construct(
        MemberLoginServices $memberLoginSrv,
        MemberRepository $memberRepo,
        PlatformRepository $platformRepo
    ) {
        $this->memberLoginSrv = $memberLoginSrv;
        $this->memberRepo     = $memberRepo;
        $this->platformRepo   = $platformRepo;
    }

    /**
     * 會員導轉登入
     *
     * @param  string   $token
     * @param  string   $ip
     * @return array
     */
    public function redirect($token, $ip)
    {
        try {
            $member = $this->memberRepo->findByWhere('api_token', $token, ['platform_id', 'id', 'account', 'name']);
            if ($member == null) {
                throw new \Exception('not found', 404);
            }
            $credentials = Auth::guard('web')->attempt([
                'platform_id' => $member['platform_id'],
                'account'     => $member['account'],
                'password'    => config('custom.member.password'),
                'active'      => 1,
            ]);
            if ($credentials) {
                $member = Auth::guard('web')->user();
                $this->memberLoginSrv->store($member, $ip);
                $this->memberRepo->update($member['id'], [
                    'last_session' => session()->getId(),
                    'api_token'    => Str::random(60),
                ]);
            }
            return ['result' => $credentials];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }

    /**
     * 會員自動導轉登入
     *
     * @param  integer. $platformId
     * @param  string   $account
     * @param  string   $ip
     * @return array
     */
    public function autoRedirect($platformId, $account, $ip)
    {
        try {
            $platform = $this->platformRepo->find($platformId);
            if ($platform == null || !isset($platform['active']) || $platform['active'] != 1) {
                throw new \Exception('not found', 404);
            }
            $member = $this->memberRepo->findByAccount($platform['id'], $account);
            if ($member == null) {
                $member = $this->memberRepo->store([
                    'platform_id' => $platform['id'],
                    'account'     => $account,
                    'password'    => Hash::make(config('custom.member.password')),
                    'name'        => $account,
                    'api_token'   => Str::random(60),
                ]);
            }
            $credentials = Auth::guard('web')->attempt([
                'platform_id' => $platform['id'],
                'account'     => $account,
                'password'    => config('custom.member.password'),
                'active'      => 1,
            ]);
            if ($credentials) {
                $member = Auth::guard('web')->user();
                $this->memberLoginSrv->store($member, $ip);
                $this->memberRepo->update($member['id'], [
                    'last_session' => session()->getId(),
                ]);
            }
            return ['result' => $credentials];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
