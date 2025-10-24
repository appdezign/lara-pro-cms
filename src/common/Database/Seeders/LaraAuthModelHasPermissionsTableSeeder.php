<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraAuthModelHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_auth_model_has_permissions')->delete();
        
        
        
    }
}