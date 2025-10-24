<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraObjectSeoTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_object_seo')->delete();
        
        \DB::table('lara_object_seo')->insert(array (
            0 => 
            array (
                'id' => 46,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 3,
                'seo_title' => '1',
                'seo_description' => '2',
                'seo_keywords' => '3',
            ),
            1 => 
            array (
                'id' => 47,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 5,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            2 => 
            array (
                'id' => 48,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 22,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            3 => 
            array (
                'id' => 49,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 23,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            4 => 
            array (
                'id' => 50,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 24,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            5 => 
            array (
                'id' => 51,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 25,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            6 => 
            array (
                'id' => 52,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 26,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            7 => 
            array (
                'id' => 53,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 27,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            8 => 
            array (
                'id' => 54,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 29,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            9 => 
            array (
                'id' => 55,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 30,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            10 => 
            array (
                'id' => 56,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 31,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            11 => 
            array (
                'id' => 57,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 1,
                'seo_title' => 'Jenny Wilson',
                'seo_description' => 'Suspendisse felis nulla, sollicitudin ut maximus ac, convallis nec ipsum.',
                'seo_keywords' => 'suspendisse, sollicitudin, maximus',
            ),
            12 => 
            array (
                'id' => 58,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 2,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            13 => 
            array (
                'id' => 59,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 2,
                'seo_title' => 'About our Company',
                'seo_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vitae iaculis nunc, vitae commodo magna. Donec ac libero mi. Maecenas lacinia quam ullamcorper.',
                'seo_keywords' => 'Lorem, ipsum, dolor, sit, amet',
            ),
            14 => 
            array (
                'id' => 60,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 3,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            15 => 
            array (
                'id' => 61,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 4,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            16 => 
            array (
                'id' => 62,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 5,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            17 => 
            array (
                'id' => 63,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 6,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            18 => 
            array (
                'id' => 64,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 7,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            19 => 
            array (
                'id' => 65,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 8,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            20 => 
            array (
                'id' => 66,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 17,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            21 => 
            array (
                'id' => 67,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 19,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            22 => 
            array (
                'id' => 68,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 5,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            23 => 
            array (
                'id' => 69,
                'entity_type' => 'Lara\\App\\Models\\Video',
                'entity_id' => 1,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            24 => 
            array (
                'id' => 70,
                'entity_type' => 'Lara\\App\\Models\\Video',
                'entity_id' => 2,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            25 => 
            array (
                'id' => 71,
                'entity_type' => 'Lara\\App\\Models\\Video',
                'entity_id' => 3,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            26 => 
            array (
                'id' => 72,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 25,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            27 => 
            array (
                'id' => 73,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 14,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            28 => 
            array (
                'id' => 74,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 34,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            29 => 
            array (
                'id' => 75,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 35,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            30 => 
            array (
                'id' => 76,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 36,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            31 => 
            array (
                'id' => 77,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 37,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            32 => 
            array (
                'id' => 78,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 38,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            33 => 
            array (
                'id' => 79,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 40,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            34 => 
            array (
                'id' => 80,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 41,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            35 => 
            array (
                'id' => 81,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 42,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            36 => 
            array (
                'id' => 82,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 1,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            37 => 
            array (
                'id' => 83,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 2,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            38 => 
            array (
                'id' => 84,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 3,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            39 => 
            array (
                'id' => 85,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 5,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            40 => 
            array (
                'id' => 86,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 9,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            41 => 
            array (
                'id' => 87,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 10,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            42 => 
            array (
                'id' => 88,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 11,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            43 => 
            array (
                'id' => 89,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 12,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            44 => 
            array (
                'id' => 90,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 14,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
            45 => 
            array (
                'id' => 91,
                'entity_type' => 'Lara\\App\\Models\\City',
                'entity_id' => 1,
                'seo_title' => NULL,
                'seo_description' => NULL,
                'seo_keywords' => NULL,
            ),
        ));
        
        
    }
}