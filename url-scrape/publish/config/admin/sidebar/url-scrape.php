<?php

return [
    [
        'name' => 'Url Scrapes',
        'url' => 'admin/sources/url-scrape',
        'position' => 1,
        'section' => 'sources',
        'sub_section' => 'url-scrape',
        'active_pattern' => 'admin/sources/url-scrape*',
        'menu_items' => [
            [
                'name' => 'Dashboard',
                'url' => '/admin/sources/url-scrape/dashboard',
            ],
            [
                'name' => 'Scrapes',
                'url' => '/admin/sources/url-scrape/scrape',
            ],
            [
                'name' => 'Urls',
                'url' => '/admin/sources/url-scrape/url',
            ]
        ]
    ]
];