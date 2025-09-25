<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraAuthRolesTableSeeder extends Seeder
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
                'created_at' => '2025-06-17 19:21:45',
                'updated_at' => '2025-06-17 19:21:45',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'administrator',
                'guard_name' => 'web',
                'created_at' => '2025-06-17 19:21:45',
                'updated_at' => '2025-06-17 19:21:45',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'webmaster',
                'guard_name' => 'web',
                'created_at' => '2025-06-17 19:21:45',
                'updated_at' => '2025-06-17 19:21:45',
            ),
        ));
        
        
    }
}