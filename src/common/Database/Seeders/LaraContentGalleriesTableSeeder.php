<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraContentGalleriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_content_galleries')->delete();
        
        \DB::table('lara_content_galleries')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'Team at work',
                'slug' => 'team-at-work',
                'slug_lock' => 0,
                'lead' => NULL,
                'body' => NULL,
                'created_at' => '2025-08-28 14:43:33',
                'updated_at' => '2025-08-29 12:31:49',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-08-28 14:43:00',
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
                'title' => 'New tech',
                'slug' => 'new-tech',
                'slug_lock' => 0,
                'lead' => NULL,
                'body' => NULL,
                'created_at' => '2025-08-29 12:32:13',
                'updated_at' => '2025-08-29 12:36:23',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-08-29 12:32:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
        ));
        
        
    }
}