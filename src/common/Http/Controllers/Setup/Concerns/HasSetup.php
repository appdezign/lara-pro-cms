<?php

namespace Lara\Common\Http\Controllers\Setup\Concerns;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

trait HasSetup
{
	private function laraNeedsSetup()
	{
		$tablename = config('lara-common.database.ent.entities', 'lara_resource_entities');

		return !Schema::hasTable($tablename) || DB::table($tablename)->count() == 0;
	}

	/**
	 * @param int $step
	 * @return void
	 */
	private function migrateFresh(string $type, int $step)
	{

		/*
		 * Migrations are loaded from:
		 * - Lara\Common\Database\Migrations
		 * - Lara\App\Database\Migrations
		 *
		 * See: Lara\Common\Providers\LaraCommonServiceProvider
		 */

		$commonPath = 'laracms/core/src/common/Database/Migrations';
		Artisan::call('migrate:fresh', [
			'--force' => true,
			'--path'  => $commonPath,
		]);

		if ($type == 'demo') {
			$demoPath = 'laracms/app/Database/Migrations';
			Artisan::call('migrate', [
				'--force' => true,
				'--path'  => $demoPath,
			]);
		}

		flash('Step ' . $step . ' was completed successfully')->success();

	}

	/**
	 * @param int $step
	 * @return void
	 */
	private function runSeeders(string $type, int $step)
	{

		/*
		 * Seeders are loaded from:
		 * - Lara\Common\Database\Seeders
		 * - Lara\App\Database\Seeders
		 *
		 */

		if ($type == 'essential') {
			Artisan::call('db:seed', [
				'--class' => '\Lara\Common\Database\Seeders\DatabaseCommonSeeder',
				'--force' => true,
			]);
		}

		if ($type == 'demo') {
			Artisan::call('db:seed', [
				'--class' => '\Lara\App\Database\Seeders\DatabaseDemoSeeder',
				'--force' => true,
			]);
		}

		flash('Step ' . $step . ' was completed successfully')->success();

	}

	/**
	 * @return void
	 */
	private function clearAllCache()
	{

		Artisan::call('cache:clear');
		Artisan::call('config:clear');
		Artisan::call('view:clear');

	}

	private function finishSetup($type) {

		if($type == 'essential') {
			File::cleanDirectory(base_path('laracms/app/Filament/Resources'));
			File::cleanDirectory(base_path('laracms/app/Lara'));
			File::cleanDirectory(base_path('laracms/app/Models'));
			File::cleanDirectory(base_path('laracms/app/Policies'));
			File::cleanDirectory(base_path('laracms/themes/demo/views/content'));
		}

		$this->clearAllCache();
	}

}