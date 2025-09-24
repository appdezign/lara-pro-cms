<?php

namespace Database\Seeders;;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseCustomSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

	    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		// Auth
	    $this->call(LaraAuthUsersTableSeeder::class);
	    $this->call(LaraAuthRolesTableSeeder::class);
	    $this->call(LaraAuthPermissionsTableSeeder::class);
	    $this->call(LaraAuthModelHasPermissionsTableSeeder::class);
	    $this->call(LaraAuthModelHasRolesTableSeeder::class);
	    $this->call(LaraAuthRoleHasPermissionsTableSeeder::class);
	    $this->call(LaraAuthPasswordResetTokensTableSeeder::class);

		// Blocks
        $this->call(LaraBlocksCtasTableSeeder::class);
        $this->call(LaraBlocksSlidersTableSeeder::class);
        $this->call(LaraBlocksWidgetsTableSeeder::class);

		// Content
        $this->call(LaraContentBlogsTableSeeder::class);
        $this->call(LaraContentDocsTableSeeder::class);
        $this->call(LaraContentEventsTableSeeder::class);
        $this->call(LaraContentGalleriesTableSeeder::class);
        $this->call(LaraContentLocationsTableSeeder::class);
        $this->call(LaraContentPagesTableSeeder::class);
        $this->call(LaraContentPortfoliosTableSeeder::class);
        $this->call(LaraContentServicesTableSeeder::class);
        $this->call(LaraContentTeamsTableSeeder::class);
        $this->call(LaraContentTestimonialsTableSeeder::class);
        $this->call(LaraContentVideosTableSeeder::class);

		// Forms
        $this->call(LaraFormClassicformsTableSeeder::class);
        $this->call(LaraFormContactformsTableSeeder::class);

		// Menu
        $this->call(LaraMenuMenuItemsTableSeeder::class);
        $this->call(LaraMenuMenusTableSeeder::class);

		// Object Relations
        $this->call(LaraObjectFilesTableSeeder::class);
        $this->call(LaraObjectImagesTableSeeder::class);
        $this->call(LaraObjectLayoutTableSeeder::class);
        $this->call(LaraObjectOpengraphTableSeeder::class);
        $this->call(LaraObjectPageablesTableSeeder::class);
        $this->call(LaraObjectRelatedTableSeeder::class);
        $this->call(LaraObjectSeoTableSeeder::class);
        $this->call(LaraObjectSyncTableSeeder::class);
        $this->call(LaraObjectTaggablesTableSeeder::class);
        $this->call(LaraObjectTagsTableSeeder::class);
        $this->call(LaraObjectTaxonomiesTableSeeder::class);
        $this->call(LaraObjectVideofilesTableSeeder::class);
        $this->call(LaraObjectVideosTableSeeder::class);

		// Resources
        $this->call(LaraResourceEntitiesTableSeeder::class);
        $this->call(LaraResourceEntityCustomFieldsTableSeeder::class);
        $this->call(LaraResourceEntityRelationsTableSeeder::class);
        $this->call(LaraResourceEntityViewsTableSeeder::class);

		// System
        $this->call(LaraSysBlacklistTableSeeder::class);
        $this->call(LaraSysLanguagesTableSeeder::class);
        $this->call(LaraSysSettingsTableSeeder::class);
        $this->call(LaraSysTranslationsTableSeeder::class);

		// 3rd party
	    $this->call(BreezySessionsTableSeeder::class);
	    $this->call(CacheTableSeeder::class);
	    $this->call(CacheLocksTableSeeder::class);
	    $this->call(CuratorTableSeeder::class);
	    $this->call(ResourceLocksTableSeeder::class);

		// Laravel
	    $this->call(MigrationsTableSeeder::class);
	    $this->call(SessionsTableSeeder::class);
	    $this->call(FailedJobsTableSeeder::class);
	    $this->call(JobBatchesTableSeeder::class);
	    $this->call(JobsTableSeeder::class);

	    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
