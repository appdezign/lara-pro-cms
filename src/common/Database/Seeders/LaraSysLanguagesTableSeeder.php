<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LaraSysLanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_sys_languages')->delete();
        
        \DB::table('lara_sys_languages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'nl',
                'name' => 'Nederlands',
                'default' => 1,
                'backend' => 1,
                'backend_default' => 1,
                'publish' => 1,
                'position' => 1,
                'created_at' => NULL,
                'updated_at' => '2024-03-05 17:50:09',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'en',
                'name' => 'English',
                'default' => 0,
                'backend' => 1,
                'backend_default' => 0,
                'publish' => 1,
                'position' => 2,
                'created_at' => NULL,
                'updated_at' => '2024-03-05 17:50:09',
            ),
        ));
        
        
    }
}