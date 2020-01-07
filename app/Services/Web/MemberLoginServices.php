<?php

namespace App\Services\Web;

use GeoIP;
use Jenssegers\Agent\Agent;
use App\Repositories\Member\MemberLoginRepository;

class MemberLoginServices
{
    protected $memberLoginRepo;

    public function __construct(
        MemberLoginRepository $memberLoginRepo
    ) {
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
                'area'           => $this->getArea($ip),
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

    /**
     * 取得IP所屬地區
     *
     * @param  string $ip
     * @return string
     */
    public function getArea($ip)
    {
        try {
            $info = GeoIp::getLocation($ip);
            return ((isset($info['country']) && $info['country'] != '') ? $info['country'] . ', ' : ''). ($info['city'] ?? '');
        } catch (\Exception $e) {
            return '';
        }
    }
}
