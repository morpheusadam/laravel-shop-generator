<?php

return [
    'manifest' => [
        'id' => 'pwa',
        'name' => env('APP_NAME', 'FleetCart'),
        'description' => 'Revolutionize your online business with the cutting-edge FleetCart e-commerce solution.',
        'short_name' => env('APP_NAME', 'FleetCart'),
        'dir' => 'auto',
        'lang' => 'en',
        'scope' => '/',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#0068e1',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => '#0068e1',
        'icons' => [
            [
                'path' => '/pwa/icons/48x48.png',
                'sizes' => '48x48',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'path' => '/pwa/icons/72x72.png',
                'sizes' => '72x72',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'path' => '/pwa/icons/96x96.png',
                'sizes' => '96x96',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'path' => '/pwa/icons/128x128.png',
                'sizes' => '128x128',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'path' => '/pwa/icons/144x144.png',
                'sizes' => '144x144',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'path' => '/pwa/icons/152x152.png',
                'sizes' => '152x152',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'path' => '/pwa/icons/192x192.png',
                'type' => 'image/png',
                'sizes' => '192x192',
                'purpose' => 'any',
            ],
            [
                'path' => '/pwa/icons/384x384.png',
                'sizes' => '384x384',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'path' => '/pwa/icons/512x512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
        ],
        //'shortcuts' => [
        //    [
        //        'name' => 'Shortcut 1 Name',
        //        'url' => '/',
        //        'description' => 'Shortcut 1 Description',
        //        'icons' => [
        //            'src' => 'Shortcut Icon Url',
        //            'type' => 'images/png',
        //            'purpose' => 'purpose',
        //        ]
        //    ],
        //],
        //'screenshots' => [
        //    [
        //        'src' => 'Screenshot Url',
        //        'label' => 'Desktop Screenshot',
        //        'type' => 'images/png',
        //        'form_factor' => 'wide',
        //    ],
        //    [
        //        'src' => 'Screenshot Url',
        //        'label' => 'Screenshot label',
        //        'type' => 'images/png',
        //        'form_factor' => 'narrow',
        //    ],
        //],
        'custom' => [],
    ],
    'splashes' => [
        '640x1136' => '/pwa/splashes/640x1136.png',
        '750x1334' => '/pwa/splashes/750x1334.png',
        '828x1792' => '/pwa/splashes/828x1792.png',
        '1125x2436' => '/pwa/splashes/1125x2436.png',
        '1242x2208' => '/pwa/splashes/1242x2208.png',
        '1242x2688' => '/pwa/splashes/1242x2688.png',
        '1536x2048' => '/pwa/splashes/1536x2048.png',
        '1668x2224' => '/pwa/splashes/1668x2224.png',
        '1668x2388' => '/pwa/splashes/1668x2388.png',
        '2048x2732' => '/pwa/splashes/2048x2732.png',
    ],
];
