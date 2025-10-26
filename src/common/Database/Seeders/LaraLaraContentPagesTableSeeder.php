<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraLaraContentPagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_content_pages')->delete();
        
        \DB::table('lara_content_pages')->insert(array (
            0 => 
            array (
                'id' => 5,
                'user_id' => 1,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'Meet Lara',
                'slug' => 'home',
                'slug_lock' => 0,
                'body' => '<p>Erat pharetra sed at fringilla etiam nullam platea fringilla. Gravida sodales sit mauris amet massa justo. Egestas ipsum amet tortor hendrerit amet phasellus adipiscing. Eget porta posuere pellentesque sed commodo gravida dignissim dignissim iaculis. Elementum nibh duis at in.</p>',
                'body3' => NULL,
                'body2' => '<p></p>',
                'menuroute' => '/',
                'is_home' => 1,
                'template' => 'standard',
                'created_at' => '2025-04-24 16:04:06',
                'updated_at' => '2025-10-25 17:13:10',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-04-24 16:04:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => 1001,
                'cgroup' => 'page',
            ),
        ));
        
        
    }
}