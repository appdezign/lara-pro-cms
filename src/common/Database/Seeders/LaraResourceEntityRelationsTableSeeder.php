<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LaraResourceEntityRelationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_resource_entity_relations')->delete();
        
        \DB::table('lara_resource_entity_relations')->insert(array (
            0 => 
            array (
                'id' => 17,
                'entity_id' => 41,
                'type' => 'hasMany',
                'related_entity_id' => 3,
                'foreign_key' => 'location_id',
                'is_filter' => 0,
            ),
            1 => 
            array (
                'id' => 18,
                'entity_id' => 3,
                'type' => 'belongsTo',
                'related_entity_id' => 41,
                'foreign_key' => 'location_id',
                'is_filter' => 0,
            ),
            2 => 
            array (
                'id' => 19,
                'entity_id' => 41,
                'type' => 'hasMany',
                'related_entity_id' => 44,
                'foreign_key' => 'location_id',
                'is_filter' => 0,
            ),
            3 => 
            array (
                'id' => 20,
                'entity_id' => 44,
                'type' => 'belongsTo',
                'related_entity_id' => 41,
                'foreign_key' => 'location_id',
                'is_filter' => 0,
            ),
        ));
        
        
    }
}