<?php

return [
    'websiteName' => '余额宝',
    'common' => [
        'noData'    => '没有任何记录',
        'all'       => '全部',
        'plzSelect' => '请选择',
        'allSelect' => '全选',
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
        'login'  => '登入',
        'add'    => '新增',
        'edit'   => '编辑',
        'delete' => '删除',
        'log'    => '历程',
        'search' => '搜寻',
        'goList' => '返回列表',
        'submit' => '确定',
        'reset'  => '重置',
        'close'  => '关闭',
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
            'systemRole'       => '角色管理',
            'systemUser'       => '帐号管理',
            'systemLogin'      => '登入日志',
            'systemOperation'  => '操作日志',
        ],
        'table' => [
            'platformList' => [
                'name'       => '名称',
                'present'    => '目前利率(%)',
                'future'     => '预改利率(%)',
                'active'     => '状态',
                'updated_at' => '最近更新时间',
            ],
            'platformActivity' => [
                'platform_id' => '平台',
                'start_at'    => '活动开始日期',
                'end_at'      => '活动结束日期',
                'rate'        => '活动利率(%)',
                'active'      => '状态',
            ],
            'memberList' => [
                'platform_id' => '平台',
                'account'     => '帐号 (名称)',
                'balance'     => '余额宝额度',
                'active'      => '状态',
            ],
            'memberLogin' => [
                'created_at' => '登入时间',
                'platform_id' => '平台',
                'member'     => '帐号 (名称)',
                'login_ip'   => '登入IP',
                'area'       => '地区',
                'device'     => '装置',
            ],
            'systemRole' => [
                'name'       => '名称',
                'active'     => '状态',
                'created_at' => '新建时间',
            ],
            'systemUser' => [
                'role_id'    => '角色',
                'account'    => '帐号',
                'name'       => '名称',
                'active'     => '状态',
                'created_at' => '新建时间',
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
            'active'   => '状态',
            'platform' => '平台',
            'role'     => '角色',
            'type'     => '类别',
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
            'add'     => '新增',
        ],
        'detail' => [
            'create' => [
                'platformActivity' => '新增平台活动利率',
                'systemRole'       => '新增角色',
                'systemUser'       => '新增帐号',
            ],
            'edit' => [
                'platformActivity' => '编辑平台活动利率',
                'platformList'     => '编辑平台',
                'systemRole'       => '编辑角色',
                'systemUser'       => '修改帐号',
            ],
        ],
        'form' => [
            'platformList' => [
                'name'         => '名称',
                'present'      => '目前利率(%)',
                'future'       => '预设利率(%)',
                'active'       => '状态',
                'futureRemark' => '若有修改，则隔天0点生效',
            ],
            'platformActivity' => [
                'platform_id' => '平台',
                'start_at'    => '开始日期',
                'end_at'      => '结束日期',
                'rate'        => '利率(%)',
                'active'      => '状态',
            ],
            'systemRole' => [
                'name'       => '名称',
                'permission' => '功能权限设定',
                'active'     => '状态',
                'tableFunc'  => '功能',
                'is_get'     => '检视',
                'is_post'    => '新增',
                'is_put'     => '编辑',
                'is_delete'  => '删除',
            ],
            'systemUser' => [
                'account'               => '帐号',
                'password'              => '密码',
                'password_confirmation' => '确认密码',
                'name'                  => '名称',
                'role_id'               => '角色',
                'active'                => '状态',
            ],
        ],
        'placeholder' => [
            'account'               => '4~30个英文数字组合',
            'password'              => '6~20个英文数字组合',
            'name'                  => '不得超过30个字元',
            'roleName'              => '不得超过20个字元',
            'password_confirmation' => '再次输入密码',
            'future'                => '范围为1 ~ 100 (%)',
            'rateActivity'          => '范围为1 ~ 1000 (%)',
            'start_at'              => '格式：yyyy-mm-dd',
            'end_at'                => '格式：yyyy-mm-dd',
        ],
        'result' => [
            'storeSuccess'   => '新建成功',
            'storeFalse'     => '新建失败',
            'editSuccess'    => '编辑成功',
            'editFalse'      => '编辑失败',
            'destroySuccess' => '删除成功',
            'destroyFalse'   => '删除失败',
            'closeSuccess'   => '关闭成功',
            'closeFalse'     => '关闭失败',
        ],
        'statusList' => ['全部', '启用', '停用'],
        'activeList' => ['全部', '启用', '停用'],
        'typeList'   => [
            2 => '活动未开始',
            3 => '活动进行中',
            1 => '活动结束',
        ],
        'modal' => [
            'title' => [
                'delete' => '系统提示讯息',
                'close'  => '系統提示訊息',
            ],
            'body' => [
                'delete' => '确定要删除下面此资料??',
                'close'  => '确定要關閉下面此资料??(當天結束)',
            ],
        ],
    ],
];
