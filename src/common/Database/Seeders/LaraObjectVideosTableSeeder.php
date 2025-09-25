<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraObjectVideosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_object_videos')->delete();
        
        \DB::table('lara_object_videos')->insert(array (
            0 => 
            array (
                'id' => 38,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 22,
                'entity_videos' => '[]',
            ),
            1 => 
            array (
                'id' => 39,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 1,
                'entity_videos' => '[]',
            ),
            2 => 
            array (
                'id' => 40,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 2,
                'entity_videos' => '[]',
            ),
            3 => 
            array (
                'id' => 41,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 2,
                'entity_videos' => '[{"video_title": "FLYING OVER NEW YORK 4K UHD", "youtubecode": "9R0DvILdHV8"}]',
            ),
            4 => 
            array (
                'id' => 42,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 23,
                'entity_videos' => '[]',
            ),
            5 => 
            array (
                'id' => 43,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 3,
                'entity_videos' => '[]',
            ),
            6 => 
            array (
                'id' => 44,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 4,
                'entity_videos' => '[]',
            ),
            7 => 
            array (
                'id' => 45,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 5,
                'entity_videos' => '[]',
            ),
            8 => 
            array (
                'id' => 46,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 6,
                'entity_videos' => '[]',
            ),
            9 => 
            array (
                'id' => 47,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 7,
                'entity_videos' => '[]',
            ),
            10 => 
            array (
                'id' => 48,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 8,
                'entity_videos' => '[]',
            ),
            11 => 
            array (
                'id' => 49,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 27,
                'entity_videos' => '[]',
            ),
            12 => 
            array (
                'id' => 50,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 31,
                'entity_videos' => '[]',
            ),
            13 => 
            array (
                'id' => 51,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 17,
                'entity_videos' => '[]',
            ),
            14 => 
            array (
                'id' => 52,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 19,
                'entity_videos' => '[]',
            ),
            15 => 
            array (
                'id' => 53,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 30,
                'entity_videos' => '[]',
            ),
            16 => 
            array (
                'id' => 54,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 5,
                'entity_videos' => '[]',
            ),
            17 => 
            array (
                'id' => 55,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 29,
                'entity_videos' => '[]',
            ),
            18 => 
            array (
                'id' => 56,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 26,
                'entity_videos' => '[]',
            ),
            19 => 
            array (
                'id' => 57,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 25,
                'entity_videos' => '[]',
            ),
            20 => 
            array (
                'id' => 58,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 24,
                'entity_videos' => '[]',
            ),
            21 => 
            array (
                'id' => 59,
                'entity_type' => 'Lara\\App\\Models\\Video',
                'entity_id' => 1,
                'entity_videos' => '[{"video_title": "FLYING OVER NEW YORK 4K UHD", "youtubecode": "9R0DvILdHV8"}]',
            ),
            22 => 
            array (
                'id' => 60,
                'entity_type' => 'Lara\\App\\Models\\Video',
                'entity_id' => 2,
                'entity_videos' => '[{"video_title": "Above NYC - Filmed in 12K", "youtubecode": "UN3uF3990Q0"}]',
            ),
            23 => 
            array (
                'id' => 61,
                'entity_type' => 'Lara\\App\\Models\\Video',
                'entity_id' => 3,
                'entity_videos' => '[{"video_title": "Stunning New York Manhattan Flyover", "youtubecode": "W7HKVdzP_XY"}]',
            ),
            24 => 
            array (
                'id' => 62,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 25,
                'entity_videos' => '[]',
            ),
            25 => 
            array (
                'id' => 63,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 14,
                'entity_videos' => '[]',
            ),
            26 => 
            array (
                'id' => 64,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 34,
                'entity_videos' => '[]',
            ),
            27 => 
            array (
                'id' => 65,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 35,
                'entity_videos' => '[]',
            ),
            28 => 
            array (
                'id' => 66,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 36,
                'entity_videos' => '[]',
            ),
            29 => 
            array (
                'id' => 67,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 37,
                'entity_videos' => '[]',
            ),
            30 => 
            array (
                'id' => 68,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 38,
                'entity_videos' => '[]',
            ),
            31 => 
            array (
                'id' => 69,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 40,
                'entity_videos' => '[]',
            ),
            32 => 
            array (
                'id' => 70,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 41,
                'entity_videos' => '[]',
            ),
            33 => 
            array (
                'id' => 71,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 42,
                'entity_videos' => '[]',
            ),
        ));
        
        
    }
}