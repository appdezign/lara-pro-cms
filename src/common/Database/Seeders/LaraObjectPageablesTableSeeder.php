<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraObjectPageablesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_object_pageables')->delete();
        
        \DB::table('lara_object_pageables')->insert(array (
            0 => 
            array (
                'id' => 24,
                'page_id' => 2,
                'entity_type' => 'Lara\\Common\\Models\\Widget',
                'entity_id' => 2,
            ),
            1 => 
            array (
                'id' => 25,
                'page_id' => 17,
                'entity_type' => 'Lara\\Common\\Models\\Widget',
                'entity_id' => 2,
            ),
            2 => 
            array (
                'id' => 28,
                'page_id' => 5,
                'entity_type' => 'Lara\\Common\\Models\\Widget',
                'entity_id' => 1,
            ),
            3 => 
            array (
                'id' => 29,
                'page_id' => 5,
                'entity_type' => 'Lara\\Common\\Models\\LaraWidget',
                'entity_id' => 3,
            ),
            4 => 
            array (
                'id' => 30,
                'page_id' => 5,
                'entity_type' => 'Lara\\Common\\Models\\LaraWidget',
                'entity_id' => 4,
            ),
            5 => 
            array (
                'id' => 31,
                'page_id' => 5,
                'entity_type' => 'Lara\\Common\\Models\\LaraWidget',
                'entity_id' => 5,
            ),
            6 => 
            array (
                'id' => 32,
                'page_id' => 5,
                'entity_type' => 'Lara\\Common\\Models\\LaraWidget',
                'entity_id' => 6,
            ),
            7 => 
            array (
                'id' => 34,
                'page_id' => 2,
                'entity_type' => 'Lara\\Common\\Models\\LaraWidget',
                'entity_id' => 2,
            ),
            8 => 
            array (
                'id' => 35,
                'page_id' => 14,
                'entity_type' => 'Lara\\Common\\Models\\LaraWidget',
                'entity_id' => 1,
            ),
            9 => 
            array (
                'id' => 36,
                'page_id' => 2,
                'entity_type' => 'Lara\\Common\\Models\\LaraWidget',
                'entity_id' => 12,
            ),
            10 => 
            array (
                'id' => 37,
                'page_id' => 2,
                'entity_type' => 'Lara\\Common\\Models\\LaraWidget',
                'entity_id' => 13,
            ),
        ));
        
        
    }
}