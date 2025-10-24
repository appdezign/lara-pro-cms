<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraObjectLayoutTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_object_layout')->delete();
        
        \DB::table('lara_object_layout')->insert(array (
            0 => 
            array (
                'id' => 1,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 2,
                'header' => NULL,
                'hero' => NULL,
                'pagetitle' => NULL,
                'content' => NULL,
                'share' => NULL,
                'cta' => 'contact',
                'footer' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 17,
                'header' => NULL,
                'hero' => NULL,
                'pagetitle' => NULL,
                'content' => NULL,
                'share' => NULL,
                'cta' => NULL,
                'footer' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 19,
                'header' => NULL,
                'hero' => NULL,
                'pagetitle' => NULL,
                'content' => NULL,
                'share' => NULL,
                'cta' => NULL,
                'footer' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 5,
                'header' => NULL,
                'hero' => 'hero_slider_100',
                'pagetitle' => NULL,
                'content' => 'full_width',
                'share' => NULL,
                'cta' => 'hidden',
                'footer' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 25,
                'header' => NULL,
                'hero' => NULL,
                'pagetitle' => NULL,
                'content' => NULL,
                'share' => NULL,
                'cta' => NULL,
                'footer' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 14,
                'header' => NULL,
                'hero' => NULL,
                'pagetitle' => NULL,
                'content' => 'boxed_default_col_10',
                'share' => NULL,
                'cta' => NULL,
                'footer' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 34,
                'header' => NULL,
                'hero' => NULL,
                'pagetitle' => NULL,
                'content' => NULL,
                'share' => NULL,
                'cta' => NULL,
                'footer' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 35,
                'header' => NULL,
                'hero' => NULL,
                'pagetitle' => NULL,
                'content' => NULL,
                'share' => NULL,
                'cta' => NULL,
                'footer' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 36,
                'header' => NULL,
                'hero' => NULL,
                'pagetitle' => NULL,
                'content' => NULL,
                'share' => NULL,
                'cta' => NULL,
                'footer' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 37,
                'header' => NULL,
                'hero' => NULL,
                'pagetitle' => NULL,
                'content' => 'boxed_default_col_10',
                'share' => NULL,
                'cta' => NULL,
                'footer' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 38,
                'header' => NULL,
                'hero' => NULL,
                'pagetitle' => NULL,
                'content' => NULL,
                'share' => NULL,
                'cta' => NULL,
                'footer' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 40,
                'header' => NULL,
                'hero' => NULL,
                'pagetitle' => NULL,
                'content' => 'boxed_default_col_10',
                'share' => NULL,
                'cta' => NULL,
                'footer' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 41,
                'header' => NULL,
                'hero' => NULL,
                'pagetitle' => NULL,
                'content' => NULL,
                'share' => NULL,
                'cta' => NULL,
                'footer' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 42,
                'header' => NULL,
                'hero' => NULL,
                'pagetitle' => NULL,
                'content' => NULL,
                'share' => NULL,
                'cta' => NULL,
                'footer' => NULL,
            ),
        ));
        
        
    }
}