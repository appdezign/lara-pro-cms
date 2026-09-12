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
                'slug' => 'meet-lara',
                'slug_lock' => 0,
                'body' => '<p>Lara CMS erat pharetra sed at fringilla etiam nullam platea fringilla. Gravida sodales sit mauris amet massa justo. Egestas ipsum amet tortor hendrerit amet phasellus adipiscing. Eget porta posuere <a href="https://firmaq.nl/nl/diensten/content-management" target="_blank">pellentesque</a> sed commodo gravida dignissim dignissim iaculis. <a href="https://laracms10.test/nl/services">Elementum</a> nibh duis at in.</p>',
                'ishome' => 1,
                'body3' => NULL,
                'body2' => '<p></p>',
                'menuroute' => '/',
                'template' => 'standard',
                'created_at' => '2025-04-24 16:04:06',
                'updated_at' => '2026-09-12 13:20:13',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-04-24 16:04:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => 1001,
                'cgroup' => 'page',
                'locked_at' => NULL,
                'locked_by' => NULL,
            ),
        ));
        
        
    }
}