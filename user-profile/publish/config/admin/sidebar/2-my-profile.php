<?php

return [
    [
        'name' => 'My Profile',
        'url' => 'admin/account/user-profile',
        'position' => 20,
        'section' => 'account',
        'sub_section' => 'user-profile',
        'active_pattern' => 'admin/account/user-profile*',
        'menu_items' => [
            [
                'name' => 'Dashboard',
                'url' => 'admin/account/user-profile/dashboard',
            ],

            [
                'name' => 'My Domains',
                'url' => 'admin/account/user-profile/domain',
            ],
            [
                'name' => 'Contact Details',
                'url' => 'admin/account/user-profile/contact',
            ],
            [
                'name' => 'Change Password',
                'url' => 'admin/account/user-profile/password/change',
            ],

        ]
    ]

];