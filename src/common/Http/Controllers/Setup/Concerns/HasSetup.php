<?php

namespace Lara\Common\Http\Controllers\Setup\Concerns;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
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
	private function migrateFresh(int $step)
	{

		/*
		 * Migrations are loaded from:
		 * - Lara\Common\Database\Migrations
		 * - Lara\App\Database\Migrations
		 *
		 * See: Lara\Common\Providers\LaraCommonServiceProvider
		 */
		Artisan::call('migrate:fresh', [
			'--force' => true,
		]);

		flash('Step ' . $step . ' was completed successfully')->success();

	}

	/**
	 * @param int $step
	 * @return void
	 */
	private function runSeeders(int $step)
	{

		Artisan::call('db:seed', [
			'--class' => 'Lara\Common\Database\Seeders\DatabaseCommonSeeder',
			'--force' => true,
		]);

		Artisan::call('db:seed', [
			'--class' => 'Lara\App\Database\Seeders\DatabaseAppSeeder',
			'--force' => true,
		]);

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

}