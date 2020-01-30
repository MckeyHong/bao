<?php

return [
    'member' => [
        'password' => 'b5ju81242uxv1hjo'
    ],
    'admin' => [
        'paginate' => 15,
    ],
    'api' => [
        'domain' => env('MEMBER_DOMAIN_URL', ''),
        'time'   => 'required|date_format:YmdHis|date|after_or_equal:' . date("Y-m-d H:i:s", strtotime("-500 minute")),
        'code' => [
            'succcess'    => 200000,
            'systemError' => 500000,
        ],
        'error' => [
            'systemError' => 'Internal Server Error',
        ],
    ],
];
