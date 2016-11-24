<?php

return [
    [
        'name' => 'Subscription',
        'url' => 'admin/account/subscription',
        'position' => 10,
        'section' => 'account',
        'sub_section' => 'subscription',
        'active_pattern' => 'admin/account/subscription*',
        'menu_items' => [
            [
                'name' => 'Dashboard',
                'url' => 'admin/account/subscription/dashboard',
            ],
            [
                'name' => 'Subscription',
                'url' => 'admin/account/subscription',
                'active_pattern' => 'admin/account/subscription',
            ],
            [
                'name' => 'Invoices',
                'url' => 'admin/account/subscription/invoices',
            ],
            [
                'name' => 'Cancel Account',
                'url' => 'admin/account/subscription/cancel',
            ],
        ]
    ]
];