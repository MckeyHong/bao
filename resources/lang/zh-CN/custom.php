<?php

return [
    'websiteName' => '余额宝',
    'common' => [
        'noData' => '没有任何记录',
        'all'    => '全部',
    ],
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
            'platformList' => [
                'name'       => '名称',
                'present'    => '目前利率',
                'future'     => '预改利率',
                'active'     => '状态',
                'updated_at' => '最近更新时间',
            ],
            'memberList' => [
                'platform_id' => '平台',
                'account'     => '帐号 (名称)',
                'balance'     => '余额宝额度',
                'active'      => '状态',
            ],
            'systemLogin' => [
                'created_at' => '登入时间',
                'user'       => '帐号 (名称)',
                'login_ip'   => '登入IP',
                'area'       => '地区',
                'status'     => '状态',
            ],
        ],
        'search' => [
            'time'     => '时间',
            'account'  => '帐号',
            'status'   => '状态',
            'platform' => '平台',
        ],
        'text' => [
            'action' => '操作',
            'log'    => '历程',
            'record' => '纪录',
            'system' => [
                'loginSuccess'  => '登入成功',
                'loginFalse'    => '登入失败',
                'logoutAuto'    => '强制登出',
                'logoutSuccess' => '正常登出',
            ],
            'enable'  => '启用',
            'disable' => '停用',
        ],
        'statusList' => ['全部', '启用', '停用'],
    ],
];
