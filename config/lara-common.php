<?php

return [

	'database' => [

		'db_connection' => env('DB_CONNECTION', null),
		'db_database'   => env('DB_DATABASE'),

		'prefix' => 'lara_',

		'entity' => [
			'block_prefix'    => 'lara_blocks_',
			'content_prefix'  => 'lara_content_',
			'entity_prefix'   => 'lara_content_',
			'page_prefix'     => 'lara_content_',
			'form_prefix'     => 'lara_form_',
			'taxonomy_prefix' => 'lara_object_',
		],

		'auth' => [
			'users'           => 'lara_auth_users',
			'password_resets' => 'lara_auth_password_reset_tokens',
			'sessions'        => 'lara_auth_sessions',
		],

		'menu' => [
			'menus'     => 'lara_menu_menus',
			'menuitems' => 'lara_menu_menu_items',
			'redirects' => 'lara_menu_redirects',
		],

		'object' => [
			'files'      => 'lara_object_files',
			'images'     => 'lara_object_images',
			'layout'     => 'lara_object_layout',
			'opengraph'  => 'lara_object_opengraph',
			'pageables'  => 'lara_object_pageables',
			'related'    => 'lara_object_related',
			'seo'        => 'lara_object_seo',
			'sync'       => 'lara_object_sync',
			'taggables'  => 'lara_object_taggables',
			'terms'      => 'lara_object_tags',
			'tags'       => 'lara_object_tags',
			'taxonomy'   => 'lara_object_taxonomies',
			'videos'     => 'lara_object_videos',
			'videofiles' => 'lara_object_videofiles',
		],

		'sys' => [
			'languages'    => 'lara_sys_languages',
			'settings'     => 'lara_sys_settings',
			'translations' => 'lara_sys_translations',
		],

		'ent' => [
			'entities'            => 'lara_resource_entities',
			'entitycustomcolumns' => 'lara_resource_entity_custom_fields',
			'entityrelations'     => 'lara_resource_entity_relations',
			'entityviews'         => 'lara_resource_entity_views',
		],

	],

	'setup' => [
		'passwords'  => [
			'min_length' => env('LARA_PASSWORDS_MIN_LENGTH', 6),
		],
	],
];
