<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraContentVideosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_content_videos')->delete();
        
        \DB::table('lara_content_videos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'New York City #1',
                'slug' => 'new-york-city-1',
                'slug_lock' => 0,
                'lead' => NULL,
                'body' => NULL,
                'created_at' => '2025-08-29 14:03:19',
                'updated_at' => '2025-08-29 14:04:39',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-08-29 14:03:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'New York City #2',
                'slug' => 'new-york-city-2',
                'slug_lock' => 0,
                'lead' => NULL,
                'body' => NULL,
                'created_at' => '2025-08-29 14:03:19',
                'updated_at' => '2025-08-29 14:05:39',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-08-29 14:03:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'New York City #3',
                'slug' => 'new-york-city-3',
                'slug_lock' => 0,
                'lead' => NULL,
                'body' => NULL,
                'created_at' => '2025-08-29 14:03:19',
                'updated_at' => '2025-08-29 14:06:37',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-08-29 14:03:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
        ));
        
        
    }
}