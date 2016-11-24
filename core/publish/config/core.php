<?php

return [
    'bindings' => [
        'repositories' => getConfigValues( base_path().'/config/bindings' )
    ],

    'api_domains' => [
        'core' => env('CORE_API_DOMAIN', 'api.topicmine.io'),
        'sources' => env('SOURCES_API_DOMAIN', 'sources.topicmine.io'),
        'models' => env('MODELS_API_DOMAIN', 'models.topicmine.io'),
        'analytics' => env('ANALYTICS_API_DOMAIN', 'analytics.topicmine.io'),
    ],

    'menu' => [
        'admin' => [
            'sidebar' => getSortedConfigValues( base_path().'/config/admin/sidebar' ),
            'sitemap' => [
                [
                    'name' => 'Account',
                    'url' => 'admin/account',
                    'section' => 'account',
                    'position' => 0,
                ],
                [
                    'name' => 'Sources',
                    'url' => 'admin/sources',
                    'section' => 'sources',
                    'position' => 1,
                ],
                [
                    'name' => 'Models',
                    'url' => 'admin/models',
                    'section' => 'models',
                    'position' => 2,
                ],
                [
                    'name' => 'Analytics',
                    'url' => 'admin/analytics',
                    'section' => 'analytics',
                    'position' => 3,
                ],
            ],
        ]
    ]
];
