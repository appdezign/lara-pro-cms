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

		$tables = DB::connection()->getSchemaBuilder()->getTables();
		foreach ($tables as $table) {

			$tablename = $table['name'];

			$exclude = [
				'breezy_sessions',
				'cache',
				'cache_locks',
				'failed_jobs',
				'job_batches',
				'jobs',
				'migrations',
				'resource_locks',
				'sessions',
			];

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