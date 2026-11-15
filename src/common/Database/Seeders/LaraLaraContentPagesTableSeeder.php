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
                'id' => 19,
                'user_id' => 3,
                'language' => 'en',
                'language_parent' => 2,
                'title' => '[en] About',
                'slug' => 'en-about',
                'slug_lock' => 0,
                'body' => '<p></p>',
                'ishome' => 1,
                'body3' => NULL,
                'body2' => NULL,
                'menuroute' => '/',
                'template' => 'standard',
                'created_at' => '2025-07-13 12:51:47',
                'updated_at' => '2026-09-19 15:15:56',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-07-13 12:51:00',
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
