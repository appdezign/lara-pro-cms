<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraLaraAuthRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_auth_roles')->delete();
        
        \DB::table('lara_auth_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'superadmin',
                'guard_name' => 'web',
                'has_panel_access' => 1,
                'level' => 100,
                'created_at' => '2025-06-17 19:21:45',
                'updated_at' => '2025-06-17 19:21:45',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'administrator',
                'guard_name' => 'web',
                'has_panel_access' => 1,
                'level' => 95,
                'created_at' => '2025-06-17 19:21:45',
                'updated_at' => '2025-06-17 19:21:45',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'webmaster',
                'guard_name' => 'web',
                'has_panel_access' => 1,
                'level' => 90,
                'created_at' => '2025-06-17 19:21:45',
                'updated_at' => '2025-12-19 14:07:13',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'member',
                'guard_name' => 'web',
                'has_panel_access' => 0,
                'level' => 10,
                'created_at' => '2026-03-17 20:22:33',
                'updated_at' => '2026-03-17 20:22:33',
            ),
        ));
        
        
    }
}