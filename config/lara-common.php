<?php

return [

	'database' => [

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
			'images'     => 'lara_object_images',
			'videos'     => 'lara_object_videos',
			'videofiles' => 'lara_object_videofiles',
			'files'      => 'lara_object_files',
			'layout'     => 'lara_object_layout',
			'terms'      => 'lara_object_tags',
			'tags'       => 'lara_object_tags',
			'taxonomy'   => 'lara_object_taxonomies',
			'taggables'  => 'lara_object_taggables',
			'pageables'  => 'lara_object_pageables',
			'relatables' => 'lara_object_relatables',
			'sync'       => 'lara_object_sync',
			'seo'        => 'lara_object_seo',
			'opengraph'  => 'lara_object_opengraph',
		],

		'sys' => [
			'languages'    => 'lara_sys_languages',
			'settings'     => 'lara_sys_settings',
			'translations' => 'lara_sys_translations',
			'jobs'         => 'lara_sys_jobs',
			'job_batches'  => 'lara_sys_job_batches',
			'failed_jobs'  => 'lara_sys_failed_jobs',
		],

		'ent' => [
			'entities'              => 'lara_ent_entities',
			'entitycolumns'         => 'lara_ent_entity_columns',
			'entitycustomcolumns'   => 'lara_ent_entity_custom_fields',
			'entityfilters'         => 'lara_ent_entity_filters',
			'entityobjectrelations' => 'lara_ent_entity_object_relations',
			'entitypanels'          => 'lara_ent_entity_panels',
			'entityrelations'       => 'lara_ent_entity_relations',
			'entityviews'           => 'lara_ent_entity_views',
		],

	],

];
