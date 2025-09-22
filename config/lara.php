<?php

return [

	'og_company_title' => 'Firmaq Media',

	'client_theme' => env('LARA_CLIENT_THEME', 'demo'),

	'needs_setup' => env('LARA_NEEDS_SETUP', false),

	'google_maps_api_key'      => env('GOOGLE_MAPS_API_KEY'),
	'google_translate_api_key' => env('GOOGLE_TRANSLATE_API_KEY'),
	'google_recaptcha_site_key'   => env('GOOGLE_RECAPTCHA_SITE_KEY'),
	'google_recaptcha_secret_key' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),

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
        ]
    ],
	'uploads' => [
		'disk' => 'public',
		'images' => [
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
			Lara\App\Filament\Components\CustomBlocks\Hero2Block::class,
			Lara\Admin\Components\CustomBlocks\HeroBlock::class,

		]
	],

	'forms_anti_spam' => [
		'threshold'           => 100,
		'spam_score_link'     => 50,
		'spam_score_email'    => 50,
		'spam_score_language' => 100,
	],


];
