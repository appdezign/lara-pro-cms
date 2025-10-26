<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseCommonSeeder extends Seeder
{
	use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

	    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		#iseed_start

	    $this->call(LaraLaraAuthModelHasPermissionsTableSeeder::class);
	    $this->call(LaraLaraAuthModelHasRolesTableSeeder::class);
	    $this->call(LaraLaraAuthPasswordResetTokensTableSeeder::class);
	    $this->call(LaraLaraAuthPermissionsTableSeeder::class);
	    $this->call(LaraLaraAuthRoleHasPermissionsTableSeeder::class);
	    $this->call(LaraLaraAuthRolesTableSeeder::class);
	    $this->call(LaraLaraAuthUsersTableSeeder::class);
	    $this->call(LaraLaraContentPagesTableSeeder::class);
	    $this->call(LaraLaraMenuMenuItemsTableSeeder::class);
	    $this->call(LaraLaraMenuMenusTableSeeder::class);
	    $this->call(LaraLaraObjectTaxonomiesTableSeeder::class);
	    $this->call(LaraLaraResourceEntitiesTableSeeder::class);
	    $this->call(LaraLaraResourceEntityCustomFieldsTableSeeder::class);
	    $this->call(LaraLaraResourceEntityViewsTableSeeder::class);
	    $this->call(LaraLaraSysLanguagesTableSeeder::class);
	    $this->call(LaraLaraSysSettingsTableSeeder::class);
	    $this->call(LaraLaraSysTranslationsTableSeeder::class);
		#iseed_end

	    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
