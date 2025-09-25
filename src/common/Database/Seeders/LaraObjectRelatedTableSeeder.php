<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraObjectRelatedTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_object_related')->delete();
        
        \DB::table('lara_object_related')->insert(array (
            0 => 
            array (
                'id' => 11,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 2,
                'related_page_objects' => '[{"page_object_id": 25}]',
                'related_entity_objects' => '[{"object_id": 24, "resource_slug": "blogs"}, {"object_id": 1, "resource_slug": "docs"}]',
                'related_entities' => '[{"module_page_menu_id": 20}]',
            ),
            1 => 
            array (
                'id' => 12,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 22,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            2 => 
            array (
                'id' => 13,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 1,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            3 => 
            array (
                'id' => 14,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 2,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            4 => 
            array (
                'id' => 15,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 3,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            5 => 
            array (
                'id' => 16,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 4,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            6 => 
            array (
                'id' => 17,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 5,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            7 => 
            array (
                'id' => 18,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 6,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            8 => 
            array (
                'id' => 19,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 7,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            9 => 
            array (
                'id' => 20,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 8,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            10 => 
            array (
                'id' => 21,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 27,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            11 => 
            array (
                'id' => 22,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 31,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            12 => 
            array (
                'id' => 23,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 23,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            13 => 
            array (
                'id' => 24,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 17,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            14 => 
            array (
                'id' => 25,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 19,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            15 => 
            array (
                'id' => 26,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 30,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            16 => 
            array (
                'id' => 27,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 5,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            17 => 
            array (
                'id' => 28,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 29,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            18 => 
            array (
                'id' => 29,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 26,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            19 => 
            array (
                'id' => 30,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 25,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            20 => 
            array (
                'id' => 31,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 24,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            21 => 
            array (
                'id' => 32,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 25,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            22 => 
            array (
                'id' => 33,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 14,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            23 => 
            array (
                'id' => 34,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 34,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            24 => 
            array (
                'id' => 35,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 35,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            25 => 
            array (
                'id' => 36,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 36,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            26 => 
            array (
                'id' => 37,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 37,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            27 => 
            array (
                'id' => 38,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 38,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            28 => 
            array (
                'id' => 39,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 40,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            29 => 
            array (
                'id' => 40,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 41,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
            30 => 
            array (
                'id' => 41,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 42,
                'related_page_objects' => '[]',
                'related_entity_objects' => '[]',
                'related_entities' => '[]',
            ),
        ));
        
        
    }
}