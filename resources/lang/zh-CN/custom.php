<?php

return [
    'websiteName' => '余额宝',
    'web' => [
        'func' => [
            '/'          => '',
            'deposit'    => '立即充值',
            'withdrawal' => '一键提领',
            'record'     => '历程查询',
            'rule'       => '规则说明',
        ],
    ],
    'button' => [
        'login' => '登入',
    ],
    'admin' => [
        'browser' => '管理系统',
        'func'    => [
            'profile'          => '个人资讯',
            'profileSetting'   => '设置',
            'profileLogout'    => '登出',
            'dashboard'        => '主页',
            'platform'         => '平台管理',
            'platformList'     => '平台清单',
            'platformActivity' => '平台活动利率',
            'member'           => '会员管理',
            'memberList'       => '会员清单',
            'memberTransfer'   => '会员历程查询',
            'memberLogin'      => '会员登入日志',
            'report'           => '统计报表',
            'reportMember'     => '会员报表',
            'reportInterest'   => '利息报表',
            'system'           => '系统管理',
            'systemRole'       => '权限管理',
            'systemUser'       => '帐号管理',
            'systemLogin'      => '登入日志',
            'systemOperation'  => '操作日志',
        ],
        'table' => [
            'systemLogin' => [
                'created_at' => '登入时间',
                'user'       => '帐号 (名称)',
                'login_ip'   => '登入IP',
                'area'       => '地区',
                'status'     => '状态',
            ],
        ],
    ],
];
