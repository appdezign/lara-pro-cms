<?php

use Lara\Admin\Components\CustomBlocks\HeroBlock;
use Lara\App\Filament\Components\CustomBlocks\Hero2Block;

return [

    'og_company_title' => 'Firmaq Media',

    'client_theme' => env('LARA_CLIENT_THEME', 'demo'),

    'needs_setup' => env('LARA_NEEDS_SETUP', false),

    'scheduler_id' => env('LARA_SCHEDULER_ID', 0),

    'admin_company_name' => 'Firmaq Beheer',
    'admin_company_email' => 'beheer@firmaq.nl',

    'google_maps_api_key' => env('GOOGLE_MAPS_API_KEY'),
    'google_translate_api_key' => env('GOOGLE_TRANSLATE_API_KEY'),
    'google_recaptcha_site_key' => env('GOOGLE_RECAPTCHA_SITE_KEY'),
    'google_recaptcha_secret_key' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),

    'auth' => [
        'has_front_auth' => env('LARA_AUTH_HAS_FRONT_AUTH', false),
        'can_register' => env('LARA_AUTH_CAN_REGISTER', false),
        'can_reset_password' => env('LARA_AUTH_CAN_RESET_PASSWORD', false),
        'has_front_profile' => env('LARA_AUTH_HAS_FRONT_PROFILE', false),
    ],

    'content_language' => [
        'languages' => [
            'nl' => 'nl',
            'en' => 'en',
        ],
        'default_language' => 'nl',
    ],

    'has_content_languages' => [
        'lara-menu-items',
        'tags',
    ],

    'translations' => [
        'modules' => [
            'lara-admin',
            'lara-common',
            'lara-front',
            'lara-app',
        ],
    ],
    'uploads' => [
        'disks' => [
            // 'local',
            'public',
            // 'larapublic',
            // 's3'
        ],
        'max_size' => 12 * 1024,
        'images' => [
            'resize_mode' => 'contain',
            'max_width' => 1920,
            'max_height' => 1920,
        ],
        'accepted_file_types' => [
            'application/pdf',
            'application/zip',
        ],
        'accepted_videofile_types' => [
            'video/mp4',
        ],

    ],

    'filament' => [
        'custom_page_permissions' => [
            'cache' => [
                'view_any_cache',
            ],
        ],
        'max_extra_body_fields' => 4,
    ],

    'rich_editor' => [
        'custom_blocks' => [
            Hero2Block::class,
            HeroBlock::class,

        ],
    ],

    'forms_anti_spam' => [
        'threshold' => 100,
        'spam_score_link' => 50,
        'spam_score_email' => 50,
        'spam_score_language' => 100,
        // hours an IP address stays blacklisted after a spam submission
        'blacklist_hours' => 24,
    ],

    // a form text containing one of these counts as a link (spam_score_link)
    'detect_link_patterns' => ['http://', 'https://', 'www.'],

    /*
     * Proxies whose X-Forwarded-* headers are trusted, so $request->ip() is the visitor and not
     * the proxy (the spam blacklist depends on it). The local proxies of the server (Varnish and
     * Nginx on Cloudways) and Cloudflare: https://www.cloudflare.com/ips (checked 2026-10-11).
     * Never use '*': a visitor could then choose their own IP address.
     */
    'trusted_proxies' => [
        '127.0.0.1',
        '::1',
        // Cloudflare IPv4
        '173.245.48.0/20',
        '103.21.244.0/22',
        '103.22.200.0/22',
        '103.31.4.0/22',
        '141.101.64.0/18',
        '108.162.192.0/18',
        '190.93.240.0/20',
        '188.114.96.0/20',
        '197.234.240.0/22',
        '198.41.128.0/17',
        '162.158.0.0/15',
        '104.16.0.0/13',
        '104.24.0.0/14',
        '172.64.0.0/13',
        '131.0.72.0/22',
        // Cloudflare IPv6
        '2400:cb00::/32',
        '2606:4700::/32',
        '2803:f800::/32',
        '2405:b500::/32',
        '2405:8100::/32',
        '2a06:98c0::/29',
        '2c0f:f248::/32',
    ],

];
