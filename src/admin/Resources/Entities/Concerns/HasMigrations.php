<?php

namespace Lara\Admin\Resources\Entities\Concerns;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Lara\Common\Models\Entity;
use Lara\Common\Models\Translation;
use Orangehill\Iseed\Facades\Iseed;

trait HasMigrations
{
	private static function createMigrations()
	{

		File::cleanDirectory(base_path('database/migrations'));

		Artisan::call('migrate:generate', [
			'--date'     => '01-09-2026 12:00:00',
			'--skip-log' => true,
		]);
	}

	private static function createSeeds()
	{
		$seedpath = base_path('database/seeders');
		File::delete(File::glob($seedpath . '/Demo*'));
		File::delete(File::glob($seedpath . '/Lara*'));

		Iseed::cleanSection();

		// 1. Essential
		$tables = [
			'lara_auth_model_has_permissions',
			'lara_auth_model_has_roles',
			'lara_auth_password_reset_tokens',
			'lara_auth_permissions',
			'lara_auth_role_has_permissions',
			'lara_auth_roles',
			'lara_auth_users',
			'lara_content_pages',
			'lara_menu_menu_items',
			'lara_menu_menus',
			'lara_object_taxonomies',
			'lara_resource_entities',
			'lara_resource_entity_custom_fields',
			'lara_resource_entity_views',
			'lara_sys_languages',
			'lara_sys_settings',
			'lara_sys_translations',
		];

		// get essential entities
		$cgroups = ['base', 'block', 'page', 'taxonomy'];
		$entityIds = Entity::whereIn('cgroup', $cgroups)->pluck('id')->toArray();
		$entityIdStr = implode(', ', $entityIds);

		// get entities and forms, so w ecvan exclude them for translations
		$excludeEntities = Entity::whereIn('cgroup', ['entity', 'form'])->pluck('resource_slug')->toArray();;
		$excludeStr = implode('\', \'', $excludeEntities);
		$excludeStr = '\'' . $excludeStr . '\'';

		foreach ($tables as $tablename) {

			switch ($tablename) {
				case 'lara_auth_users':
					$where = "name = 'superadmin'";
					break;
				case 'lara_content_pages':
				case 'lara_menu_menu_items':
					$where = "is_home = 1";
					break;
				case 'lara_resource_entities':
					$where = "id IN (" . $entityIdStr . ")";
					break;
				case 'lara_resource_entity_custom_fields':
					$where = "entity_id IN (" . $entityIdStr . ")";
					break;
				case 'lara_resource_entity_views':
					$where = "entity_id = 1";
					break;
				case 'lara_sys_translations':
					$where = "resource NOT IN (" . $excludeStr . ")";
					break;
				default:
					$where = null;
			}

			Iseed::generateSeed($tablename, 'Lara', null, null, 0, 0, null, null, null, true, true, null, 'ASC', $where);

		}

		// 2. Full Demo
		$tables = static::getAllTables();
		$exclude = [
			'breezy_sessions',
			'cache',
			'cache_locks',
			'curator',
			'failed_jobs',
			'job_batches',
			'jobs',
			'migrations',
			'resource_locks',
			'sessions',
		];
		foreach ($tables as $tablename) {
			if (!in_array($tablename, $exclude)) {
				Iseed::generateSeed($tablename, 'Demo');
			}
		}
	}

	private static function getAllTables($connection = null)
	{
		return collect(DB::connection()->select('show tables'))->map(function ($val) {
			foreach ($val as $key => $tbl) {
				return $tbl;
			}
		});
	}

}