<?php

namespace Lara\Admin\Resources\Entities\Concerns;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

trait HasMigrations
{
	private static function createMigrations() {
		Artisan::call('migrate:generate', [
			'--date' => '01-09-2026 12:00:00',
			'--skip-log' => true,
		]);
	}

	private static function createSeeds()
	{
		$seedpath = base_path('database/seeders');
		File::delete(File::glob($seedpath . '/Lara*'));

		// get all tables
		$tables = DB::select('SHOW TABLES');
		$dbname = config('lara-common.database.db_database');
		$varname = 'Tables_in_' . $dbname;

		foreach ($tables as $table) {

			$tablename = $table->$varname;

			$exclude = array();

			// exclude migration table
			$exclude[] = config('database.migrations');

			// exclude users table
			// $exclude[] = config('lara-common.database.auth.users');

			if (!in_array($tablename, $exclude)) {
				Artisan::call('iseed', [
					'tables'  => $tablename,
					'--force' => true,
					'--clean' => true,
				]);
			}
		}
	}



}