<?php

// 后台功能清单

return [
    'func' => [
        [
            'key'    => 'platform',
            'active' => ['platformList', 'platformActivity'],
            'icon'   => 'group',
            'menu'   => [
                ['key' => 'platformList', 'path' => 'ctl/platform/list'],
                ['key' => 'platformActivity', 'path' => 'ctl/platform/activity'],
            ],
        ],
        [
            'key'    => 'member',
            'active' => ['memberList', 'memberTransfer', 'memberLogin'],
            'icon'   => 'person',
            'menu'   => [
                ['key' => 'memberList', 'path' => 'ctl/member/list'],
                ['key' => 'memberTransfer', 'path' => 'ctl/member/transfer'],
                ['key' => 'memberLogin', 'path' => 'ctl/member/login'],
            ],
        ],
        [
            'key'    => 'report',
            'active' => ['reportMember', 'reportInterest'],
            'icon'   => 'pie_chart',
            'menu'   => [
                ['key' => 'reportMember', 'path' => 'ctl/report/member'],
                ['key' => 'reportInterest', 'path' => 'ctl/report/interest'],
            ],
        ],
        [
            'key'    => 'system',
            'active' => ['systemPermission', 'systemUser', 'systemLogin', 'systemOperation'],
            'icon'   => 'build',
            'menu'   => [
                ['key' => 'systemPermission', 'path' => 'ctl/system/permission'],
                ['key' => 'systemUser', 'path' => 'ctl/system/user'],
                ['key' => 'systemLogin', 'path' => 'ctl/system/login'],
                ['key' => 'systemOperation', 'path' => 'ctl/system/operation'],
            ],
        ],
    ],
];
