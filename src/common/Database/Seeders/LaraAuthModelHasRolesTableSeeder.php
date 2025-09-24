<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LaraAuthModelHasRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_auth_model_has_roles')->delete();
        
        \DB::table('lara_auth_model_has_roles')->insert(array (
            0 => 
            array (
                'role_id' => 2,
                'model_type' => 'Lara\\Common\\Models\\User',
                'model_id' => 1,
            ),
            1 => 
            array (
                'role_id' => 3,
                'model_type' => 'Lara\\Common\\Models\\User',
                'model_id' => 2,
            ),
            2 => 
            array (
                'role_id' => 1,
                'model_type' => 'Lara\\Common\\Models\\User',
                'model_id' => 3,
            ),
        ));
        
        
    }
}