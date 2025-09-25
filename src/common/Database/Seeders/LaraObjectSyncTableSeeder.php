<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraObjectSyncTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_object_sync')->delete();
        
        \DB::table('lara_object_sync')->insert(array (
            0 => 
            array (
                'id' => 6,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 2,
                'remote_url' => 'https://centraal.ambion.nl',
                'remote_suffix' => '/nl/api/',
                'remote_resource' => 'pages',
                'remote_slug' => 'about',
                'created_at' => '2025-07-09 12:44:24',
                'updated_at' => '2025-07-13 13:01:03',
            ),
            1 => 
            array (
                'id' => 7,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 17,
                'remote_url' => NULL,
                'remote_suffix' => '/nl/api/',
                'remote_resource' => 'pages',
                'remote_slug' => 'blogs-index-module-page',
                'created_at' => '2025-07-10 18:28:21',
                'updated_at' => '2025-07-10 18:28:26',
            ),
            2 => 
            array (
                'id' => 8,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 19,
                'remote_url' => NULL,
                'remote_suffix' => '/nl/api/',
                'remote_resource' => 'pages',
                'remote_slug' => 'en-about',
                'created_at' => '2025-07-13 12:51:56',
                'updated_at' => '2025-07-13 13:21:19',
            ),
            3 => 
            array (
                'id' => 9,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 5,
                'remote_url' => NULL,
                'remote_suffix' => '/nl/api/',
                'remote_resource' => 'pages',
                'remote_slug' => 'home',
                'created_at' => '2025-08-25 07:55:01',
                'updated_at' => '2025-08-25 08:56:56',
            ),
            4 => 
            array (
                'id' => 10,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 25,
                'remote_url' => NULL,
                'remote_suffix' => '/nl/api/',
                'remote_resource' => 'pages',
                'remote_slug' => 'privacy',
                'created_at' => '2025-08-29 14:27:27',
                'updated_at' => '2025-09-08 12:14:27',
            ),
            5 => 
            array (
                'id' => 11,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 14,
                'remote_url' => NULL,
                'remote_suffix' => '/nl/api/',
                'remote_resource' => 'pages',
                'remote_slug' => 'teams-index-module-nl',
                'created_at' => '2025-09-03 13:59:29',
                'updated_at' => '2025-09-03 13:59:48',
            ),
            6 => 
            array (
                'id' => 12,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 34,
                'remote_url' => NULL,
                'remote_suffix' => NULL,
                'remote_resource' => NULL,
                'remote_slug' => NULL,
                'created_at' => '2025-09-03 14:06:47',
                'updated_at' => '2025-09-03 14:06:47',
            ),
            7 => 
            array (
                'id' => 13,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 35,
                'remote_url' => NULL,
                'remote_suffix' => NULL,
                'remote_resource' => NULL,
                'remote_slug' => NULL,
                'created_at' => '2025-09-03 14:53:05',
                'updated_at' => '2025-09-03 14:53:05',
            ),
            8 => 
            array (
                'id' => 14,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 36,
                'remote_url' => NULL,
                'remote_suffix' => NULL,
                'remote_resource' => NULL,
                'remote_slug' => NULL,
                'created_at' => '2025-09-03 15:40:02',
                'updated_at' => '2025-09-03 15:40:02',
            ),
            9 => 
            array (
                'id' => 15,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 37,
                'remote_url' => NULL,
                'remote_suffix' => '/nl/api/',
                'remote_resource' => 'pages',
                'remote_slug' => 'galleries-index-module-nl',
                'created_at' => '2025-09-03 18:48:47',
                'updated_at' => '2025-09-06 18:03:04',
            ),
            10 => 
            array (
                'id' => 16,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 38,
                'remote_url' => NULL,
                'remote_suffix' => NULL,
                'remote_resource' => NULL,
                'remote_slug' => NULL,
                'created_at' => '2025-09-05 08:41:03',
                'updated_at' => '2025-09-05 08:41:03',
            ),
            11 => 
            array (
                'id' => 17,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 40,
                'remote_url' => NULL,
                'remote_suffix' => '/nl/api/',
                'remote_resource' => 'pages',
                'remote_slug' => 'videos-index-module-nl',
                'created_at' => '2025-09-06 17:41:54',
                'updated_at' => '2025-09-06 18:03:36',
            ),
            12 => 
            array (
                'id' => 18,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 41,
                'remote_url' => NULL,
                'remote_suffix' => NULL,
                'remote_resource' => NULL,
                'remote_slug' => NULL,
                'created_at' => '2025-09-06 17:45:19',
                'updated_at' => '2025-09-06 17:45:19',
            ),
            13 => 
            array (
                'id' => 19,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 42,
                'remote_url' => NULL,
                'remote_suffix' => '/nl/api/',
                'remote_resource' => 'pages',
                'remote_slug' => '404',
                'created_at' => '2025-09-08 15:45:02',
                'updated_at' => '2025-09-08 15:45:05',
            ),
        ));
        
        
    }
}