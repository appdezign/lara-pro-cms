<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LaraObjectTaxonomiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_object_taxonomies')->delete();
        
        \DB::table('lara_object_taxonomies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Category',
                'slug' => 'category',
                'slug_lock' => 1,
                'has_hierarchy' => 1,
                'is_default' => 1,
                'created_at' => '2017-11-26 12:50:34',
                'updated_at' => '2019-07-14 18:18:05',
                'locked_at' => NULL,
                'locked_by' => NULL,
                'position' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Tag',
                'slug' => 'tag',
                'slug_lock' => 1,
                'has_hierarchy' => 0,
                'is_default' => 0,
                'created_at' => '2017-11-26 12:50:48',
                'updated_at' => '2019-01-30 19:59:00',
                'locked_at' => NULL,
                'locked_by' => NULL,
                'position' => NULL,
            ),
        ));
        
        
    }
}