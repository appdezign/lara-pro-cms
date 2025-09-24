<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LaraObjectVideofilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_object_videofiles')->delete();
        
        \DB::table('lara_object_videofiles')->insert(array (
            0 => 
            array (
                'id' => 18,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 22,
                'entity_videofiles' => '[]',
            ),
            1 => 
            array (
                'id' => 19,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 23,
                'entity_videofiles' => '[]',
            ),
            2 => 
            array (
                'id' => 20,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 27,
                'entity_videofiles' => '[]',
            ),
            3 => 
            array (
                'id' => 21,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 31,
                'entity_videofiles' => '[]',
            ),
            4 => 
            array (
                'id' => 22,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 30,
                'entity_videofiles' => '[]',
            ),
            5 => 
            array (
                'id' => 23,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 29,
                'entity_videofiles' => '[]',
            ),
            6 => 
            array (
                'id' => 24,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 26,
                'entity_videofiles' => '[]',
            ),
            7 => 
            array (
                'id' => 25,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 25,
                'entity_videofiles' => '[]',
            ),
            8 => 
            array (
                'id' => 26,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 24,
                'entity_videofiles' => '[]',
            ),
        ));
        
        
    }
}