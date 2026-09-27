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

        \DB::table('lara_content_pages')->insert([
            0 => [
                'id' => 5,
                'user_id' => 1,
                'language' => 'nl',
                'language_parent' => null,
                'title' => 'Meet Lara',
                'slug' => 'meet-lara',
                'slug_lock' => 0,
                'body' => '<p>Lara CMS erat pharetra sed at fringilla etiam nullam platea fringilla. Gravida sodales sit mauris amet massa justo. Egestas ipsum amet tortor hendrerit amet phasellus adipiscing. Eget porta posuere <a href="https://firmaq.nl/nl/diensten/content-management" target="_blank">pellentesque</a> sed commodo gravida dignissim dignissim iaculis. <a href="https://laracms10.test/nl/services">Elementum</a> nibh duis at in.</p>',
                'ishome' => 1,
                'body3' => null,
                'body2' => '<p></p>',
                'menuroute' => '/',
                'template' => 'standard',
                'created_at' => '2025-04-24 16:04:06',
                'updated_at' => '2026-09-26 15:37:08',
                'deleted_at' => null,
                'publish' => 1,
                'publish_from' => '2025-04-24 16:04:00',
                'publish_expire' => 0,
                'publish_to' => null,
                'publish_hide' => 0,
                'position' => 1001,
                'cgroup' => 'page',
                'locked_at' => null,
                'locked_by' => null,
            ],
            1 => [
                'id' => 19,
                'user_id' => 3,
                'language' => 'en',
                'language_parent' => 2,
                'title' => '[en] About',
                'slug' => 'en-about',
                'slug_lock' => 0,
                'body' => '<p></p>',
                'ishome' => 1,
                'body3' => null,
                'body2' => null,
                'menuroute' => '/',
                'template' => 'standard',
                'created_at' => '2025-07-13 12:51:47',
                'updated_at' => '2026-09-19 15:15:56',
                'deleted_at' => null,
                'publish' => 1,
                'publish_from' => '2025-07-13 12:51:00',
                'publish_expire' => 0,
                'publish_to' => null,
                'publish_hide' => 0,
                'position' => 1001,
                'cgroup' => 'page',
                'locked_at' => null,
                'locked_by' => null,
            ],
        ]);

    }
}
