<?php

namespace App\Services\Web;

use Jenssegers\Agent\Agent;
use App\Services\Common\AreaServices;
use App\Repositories\Member\MemberLoginRepository;

class MemberLoginServices
{
    protected $areaSrv;
    protected $memberLoginRepo;

    public function __construct(
        AreaServices $areaSrv,
        MemberLoginRepository $memberLoginRepo
    ) {
        $this->areaSrv         = $areaSrv;
        $this->memberLoginRepo = $memberLoginRepo;
    }

    /**
     * 新增會員登入紀錄
     *
     * @param  array  $member
     * @param  string $ip
     * @return array
     */
    public function store($member, $ip)
    {
        try {
            $agent = new Agent();
            $browser = $agent->browser();
            $platform = $agent->platform();
            $this->memberLoginRepo->store([
                'platform_id'    => $member['platform_id'],
                'member_id'      => $member['id'],
                'member_name'    => $member['name'],
                'member_account' => $member['account'],
                'login_ip'       => $ip,
                'area'           => $this->areaSrv->getArea($ip),
                'device'         => ($agent->isMobile()) ? 1 : 2,
                'device_info'    => [
                    'device'           => $agent->device(),
                    'browser'          => $browser,
                    'platform'         => $platform,
                    'browser_version'  => $agent->version($browser),
                    'platform_version' => $agent->version($platform),
                ],
            ]);
            return ['result' => true];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'error'  => $e->getMessage(),
            ];
        }
    }
}
