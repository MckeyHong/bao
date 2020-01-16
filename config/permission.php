<?php

// 後台功能清單權限設置及操作日誌功能清單

return [
    // 功能列表
    'func' => [
        [
            'key'    => 'platform',
            'active' => ['platformList', 'platformActivity'],
            'icon'   => 'group',
            'menu'   => [
                ['key' => 'platformList', 'path' => 'ctl/platform/list', 'permission' => ['is_get', 'is_put']],
                ['key' => 'platformActivity', 'path' => 'ctl/platform/activity', 'permission' => ['is_get', 'is_post', 'is_put', 'is_delete']],
            ],
        ],
        [
            'key'    => 'member',
            'active' => ['memberList', 'memberTransfer', 'memberLogin'],
            'icon'   => 'person',
            'menu'   => [
                ['key' => 'memberList', 'path' => 'ctl/member/list', 'permission' => ['is_get']],
                ['key' => 'memberTransfer', 'path' => 'ctl/member/transfer', 'permission' => ['is_get']],
                ['key' => 'memberLogin', 'path' => 'ctl/member/login', 'permission' => ['is_get']],
            ],
        ],
        [
            'key'    => 'report',
            'active' => ['reportMember', 'reportInterest'],
            'icon'   => 'pie_chart',
            'menu'   => [
                ['key' => 'reportMember', 'path' => 'ctl/report/member', 'permission' => ['is_get']],
                ['key' => 'reportInterest', 'path' => 'ctl/report/interest', 'permission' => ['is_get']],
            ],
        ],
        [
            'key'    => 'system',
            'active' => ['systemRole', 'systemUser', 'systemLogin', 'systemOperation'],
            'icon'   => 'build',
            'menu'   => [
                ['key' => 'systemRole', 'path' => 'ctl/system/role', 'permission' => ['is_get', 'is_post', 'is_put', 'is_delete']],
                ['key' => 'systemUser', 'path' => 'ctl/system/user', 'permission' => ['is_get', 'is_post', 'is_put', 'is_delete']],
                ['key' => 'systemLogin', 'path' => 'ctl/system/login', 'permission' => ['is_get']],
                ['key' => 'systemOperation', 'path' => 'ctl/system/operation', 'permission' => ['is_get']],
            ],
        ],
    ],
    // 操作日誌 func_key
    'operation' => [
        'ctl/system/profile'          => 1,
        'ctl/platform/list'           => 2,
        'ctl/platform/activity'       => 3,
        'ctl/platform/activity/close' => 3,
        'ctl/system/role'             => 4,
        'ctl/system/user'             => 5,
    ],
];
