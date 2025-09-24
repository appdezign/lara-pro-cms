<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LaraBlocksCtasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_blocks_ctas')->delete();
        
        \DB::table('lara_blocks_ctas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'Get in Touch',
                'slug' => 'get-in-touch',
                'slug_lock' => 0,
                'lead' => NULL,
                'body' => '<p>Have a project in mind? To request a quote contact us directly or fill out the form and let us know how we can help.</p>',
                'overlaytransp' => '0',
                'overlaycolor' => 'black',
                'type' => 'solid',
                'hook' => 'contact',
                'linkurl' => NULL,
                'linktext' => NULL,
                'created_at' => '2025-07-11 13:22:33',
                'updated_at' => '2025-07-11 13:22:43',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-07-11 13:22:10',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'position' => NULL,
                'cgroup' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'Don\'t Want to Miss Anything?',
                'slug' => 'don-t-want-to-miss-anything',
                'slug_lock' => 0,
                'lead' => NULL,
                'body' => '<p>Sign up for Newsletters</p>',
                'overlaytransp' => '0',
                'overlaycolor' => 'black',
                'type' => 'solid',
                'hook' => 'newsletter',
                'linkurl' => NULL,
                'linktext' => NULL,
                'created_at' => '2025-07-11 13:23:59',
                'updated_at' => '2025-07-11 13:23:59',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-07-11 13:23:38',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'position' => NULL,
                'cgroup' => NULL,
            ),
        ));
        
        
    }
}