<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraContentLocationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_content_locations')->delete();
        
        \DB::table('lara_content_locations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'Marathon Music Works',
                'slug' => 'marathon-music-works',
                'slug_lock' => 0,
                'lead' => NULL,
                'body' => NULL,
                'geo_longitude' => NULL,
                'geo_latitude' => NULL,
                'geo_full_address' => NULL,
                'longitude' => '-86.79707840',
                'latitude' => '36.16409770',
                'country' => 'United States',
                'city' => 'Nashville, TN',
                'pcode' => '37203',
                'address' => '1402 Clinton St',
                'created_at' => '2025-07-04 17:37:33',
                'updated_at' => '2025-07-09 13:13:54',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-07-04 17:37:24',
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
                'title' => 'NDSM Loods',
                'slug' => 'ndsm-loods',
                'slug_lock' => 0,
                'lead' => NULL,
                'body' => NULL,
                'geo_longitude' => NULL,
                'geo_latitude' => NULL,
                'geo_full_address' => NULL,
                'longitude' => '4.89561200',
                'latitude' => '52.40185750',
                'country' => 'Nederland',
                'city' => 'Amsterdam',
                'pcode' => '1033 WC',
                'address' => 'NDSM-Plein 85',
                'created_at' => '2025-07-09 13:15:22',
                'updated_at' => '2025-07-09 13:16:05',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-07-09 13:15:01',
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
                'title' => 'Firmaq West HQ',
                'slug' => 'firmaq-west-hq',
                'slug_lock' => 0,
                'lead' => NULL,
                'body' => NULL,
                'geo_longitude' => NULL,
                'geo_latitude' => NULL,
                'geo_full_address' => NULL,
                'longitude' => '4.65418400',
                'latitude' => '52.37008840',
                'country' => 'Netherlands',
                'city' => 'Haarlem',
                'pcode' => '2035 LB',
                'address' => 'Schipholweg 66',
                'created_at' => '2025-07-09 13:16:34',
                'updated_at' => '2025-07-09 13:16:59',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-07-09 13:16:11',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'Firmaq Noord HQ',
                'slug' => 'firmaq-noord-hq',
                'slug_lock' => 0,
                'lead' => NULL,
                'body' => NULL,
                'geo_longitude' => NULL,
                'geo_latitude' => NULL,
                'geo_full_address' => NULL,
                'longitude' => '5.94465530',
                'latitude' => '52.96272830',
                'country' => 'Nederland',
                'city' => 'Heerenveen',
                'pcode' => '8448RT',
                'address' => 'Yme Kuiperweg 24',
                'created_at' => '2025-07-09 13:17:33',
                'updated_at' => '2025-07-09 13:17:50',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-07-09 13:17:20',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
        ));
        
        
    }
}