<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraLaraResourceEntityViewsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_resource_entity_views')->delete();
        
        \DB::table('lara_resource_entity_views')->insert(array (
            0 => 
            array (
                'id' => 101,
                'entity_id' => 1,
                'title' => 'Page Standard',
                'method' => 'show',
                'filename' => 'show',
                'template' => 'standard',
                'template_extra_fields' => 0,
                'is_single' => 1,
                'list_type' => '_single',
                'image_required' => 0,
                'showtags' => NULL,
                'paginate' => NULL,
                'infinite' => 0,
                'prevnext' => 0,
                'publish' => 1,
            ),
            1 => 
            array (
                'id' => 102,
                'entity_id' => 1,
                'title' => 'Page Landing',
                'method' => 'show',
                'filename' => 'show',
                'template' => 'landing',
                'template_extra_fields' => 2,
                'is_single' => 1,
                'list_type' => '_single',
                'image_required' => 0,
                'showtags' => NULL,
                'paginate' => NULL,
                'infinite' => 0,
                'prevnext' => 0,
                'publish' => 1,
            ),
        ));
        
        
    }
}