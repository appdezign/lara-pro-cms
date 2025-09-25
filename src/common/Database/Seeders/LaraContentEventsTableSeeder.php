<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraContentEventsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_content_events')->delete();
        
        \DB::table('lara_content_events')->insert(array (
            0 => 
            array (
                'id' => 1,
                'location_id' => 1,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'Laracon US',
                'slug' => 'laracon-us',
                'slug_lock' => 0,
                'lead' => '<p>Duis mollis, enim a malesuada rhoncus, lorem est volutpat magna, quis venenatis nunc nunc eu lectus. Vestibulum quis condimentum risus. Phasellus eget venenatis risus, non condimentum ex.</p>',
                'body' => '<p>Duis mollis, enim a malesuada rhoncus, lorem est volutpat magna, quis venenatis nunc nunc eu lectus. Vestibulum quis condimentum risus. Nunc et enim ac nunc posuere porttitor. Phasellus eget venenatis risus, non condimentum ex. Integer non lorem sit amet enim commodo eleifend vitae ut purus. Mauris sapien mauris, mattis quis fringilla vel, pharetra et est. Mauris et accumsan quam.</p><p>Nunc congue volutpat dui et mattis. Sed porta leo nunc. Donec posuere accumsan ipsum, et suscipit dui elementum eu. Donec auctor, sapien vitae sodales pharetra, elit enim efficitur arcu, quis cursus mauris lacus non augue. Maecenas iaculis mi id aliquam tristique. Mauris quis rutrum justo. Phasellus mattis tortor nunc, ac rutrum massa efficitur sit amet. Nulla iaculis nunc posuere, eleifend erat rutrum, pharetra magna. Sed pharetra nunc velit, at consequat erat consectetur eget. Aenean molestie pellentesque ultricies. Praesent erat ante, finibus et iaculis eget, imperdiet quis enim. Duis ultrices sapien ac nunc molestie ultricies. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>',
                'endtime' => '23:00:00',
                'enddate' => '2026-08-01',
                'starttime' => '11:00:00',
                'startdate' => '2026-08-01',
                'created_at' => '2025-07-09 18:18:15',
                'updated_at' => '2025-09-14 18:17:25',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-07-09 18:17:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'location_id' => 2,
                'user_id' => 3,
                'language' => 'nl',
                'language_parent' => NULL,
                'title' => 'Laracon EU',
                'slug' => 'laracon-eu',
                'slug_lock' => 0,
                'lead' => '<p>Maecenas ut hendrerit mauris. Suspendisse vehicula turpis eget eleifend varius. Donec scelerisque ex ligula, iaculis elementum dolor convallis a. Nam volutpat euismod varius.</p>',
                'body' => '<p>Maecenas ut hendrerit mauris. Suspendisse vehicula turpis eget eleifend varius. Donec scelerisque ex ligula, iaculis elementum dolor convallis a. Nam volutpat euismod varius. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Vivamus ligula sem, interdum rhoncus urna in, finibus sodales lorem. Maecenas sit amet metus lacus. Fusce semper nec eros vitae efficitur.</p><p>Nunc congue volutpat dui et mattis. Sed porta leo nunc. Donec posuere accumsan ipsum, et suscipit dui elementum eu. Donec auctor, sapien vitae sodales pharetra, elit enim efficitur arcu, quis cursus mauris lacus non augue. Maecenas iaculis mi id aliquam tristique. Mauris quis rutrum justo. Phasellus mattis tortor nunc, ac rutrum massa efficitur sit amet. Nulla iaculis nunc posuere, eleifend erat rutrum, pharetra magna. Sed pharetra nunc velit, at consequat erat consectetur eget. Aenean molestie pellentesque ultricies. Praesent erat ante, finibus et iaculis eget, imperdiet quis enim. Duis ultrices sapien ac nunc molestie ultricies. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>',
                'endtime' => '23:00:00',
                'enddate' => '2026-11-01',
                'starttime' => '11:00:00',
                'startdate' => '2026-11-01',
                'created_at' => '2025-07-09 18:22:12',
                'updated_at' => '2025-09-14 18:16:56',
                'deleted_at' => NULL,
                'publish' => 1,
                'publish_from' => '2025-07-09 18:22:00',
                'publish_expire' => 0,
                'publish_to' => NULL,
                'publish_hide' => 0,
                'position' => NULL,
                'cgroup' => NULL,
            ),
        ));
        
        
    }
}