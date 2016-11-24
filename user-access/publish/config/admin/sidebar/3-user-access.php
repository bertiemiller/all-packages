<?php

return [
    [
        'name' => 'User Access',
        'url' => 'admin/account/user-access',
        'position' => 11,
        'section' => 'account',
        'sub_section' => 'user-access',
        'active_pattern' => 'admin/account/user-access*',
        'menu_items' => [
            [
                'name' => 'Dashboard',
                'url' => 'admin/account/user-access/dashboard',
            ],
            [
                'name' => 'Users',
                'url' => 'admin/account/user-access/user',
            ],
            [
                'name' => 'Roles',
                'url' => 'admin/account/user-access/role',
            ],
            [
                'name' => 'Permission Groups',
                'url' => 'admin/account/user-access/permission-group',
            ],
            [
                'name' => 'Permissions',
                'url' => 'admin/account/user-access/permission',
                'active_pattern' => 'admin/account/user-access/permission',
            ]
        ]
    ]
];