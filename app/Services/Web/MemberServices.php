<?php

namespace App\Services\Web;

use DB;
use GeoIP;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use App\Repositories\Member\MemberLoginRepository;
use App\Repositories\Member\MemberRepository;

class MemberServices
{
    const PLATFORM_ID = 1;

    protected $memberLoginRepo;
    protected $memberRepo;

    public function __construct(
        MemberLoginRepository $memberLoginRepo,
        MemberRepository $memberRepo
    ) {
        $this->memberLoginRepo = $memberLoginRepo;
        $this->memberRepo      = $memberRepo;
    }

    /**
     * 會員導轉登入
     *
     * @param  string $account
     * @param  string $ip
     * @return array
     */
    public function redirect($account, $ip)
    {
        try {
            // $ip = GeoIp::getLocation('27.974.399.65');
            $result = DB::transaction(function () use ($account, $ip) {
                $member = $this->memberRepo->findByWhere('account', $account);
                if ($member == null) {
                    $member = $this->memberRepo->store([
                        'platform_id' => self::PLATFORM_ID,
                        'account'     => $account,
                        'name'        => $account,
                        'password'    => Hash::make(config('custom.member.password')),
                        'token'       => '',
                    ]);
                }
                $credentials = Auth::guard('web')->attempt([
                    'platform_id' => self::PLATFORM_ID,
                    'account'     => $account,
                    'password'    => Hash::make(config('custom.member.password')),
                    'active'      => 1,
                ]);

                $credentials = Auth::guard('web')->loginUsingId(1);
                if ($credentials) {
                    $agent = new Agent();
                    $browser = $agent->browser();
                    $platform = $agent->platform();
                    $this->memberLoginRepo->store([
                        'platform_id'    => $member['platform_id'],
                        'member_id'      => $member['id'],
                        'member_name'    => $member['name'],
                        'member_account' => $member['account'],
                        'login_ip'       => $ip,
                        'device'         => ($agent->isMobile()) ? 1 : 2,
                        'device_info'    => [
                            'device'           => $agent->device(),
                            'browser'          => $browser,
                            'platform'         => $platform,
                            'browser_version'  => $agent->version($browser),
                            'platform_version' => $agent->version($platform),
                        ],
                    ]);
                }
                return $credentials;
            });

            return [
                'result' => $result,
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
