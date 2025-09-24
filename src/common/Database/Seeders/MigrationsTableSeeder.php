<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'migration' => '0001_01_01_000000_create_users_table',
                'batch' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'migration' => '0001_01_01_000001_create_cache_table',
                'batch' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'migration' => '0001_01_01_000002_create_jobs_table',
                'batch' => 1,
            ),
            3 => 
            array (
                'id' => 5,
                'migration' => '2025_06_11_181122_create_lara_content_blogs',
                'batch' => 2,
            ),
            4 => 
            array (
                'id' => 6,
                'migration' => '2025_06_15_175334_create_lara_content_bases_table',
                'batch' => 3,
            ),
            5 => 
            array (
                'id' => 7,
                'migration' => '2025_06_17_171716_create_permission_tables',
                'batch' => 4,
            ),
            6 => 
            array (
                'id' => 8,
                'migration' => '2025_07_01_161203_create_curator_table',
                'batch' => 5,
            ),
            7 => 
            array (
                'id' => 9,
                'migration' => '2025_08_08_143455_add_renew_password_on_users_table',
                'batch' => 6,
            ),
            8 => 
            array (
                'id' => 10,
                'migration' => '2025_08_14_140923_create_resource_lock_table',
                'batch' => 7,
            ),
            9 => 
            array (
                'id' => 11,
                'migration' => '2025_09_02_183122_create_breezy_sessions_table',
                'batch' => 8,
            ),
            10 => 
            array (
                'id' => 12,
                'migration' => '2025_09_02_183123_alter_breezy_sessions_table',
                'batch' => 8,
            ),
        ));
        
        
    }
}