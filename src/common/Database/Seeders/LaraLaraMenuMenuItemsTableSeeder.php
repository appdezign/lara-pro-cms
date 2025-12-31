<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraLaraMenuMenuItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_menu_menu_items')->delete();
        
        \DB::table('lara_menu_menu_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'language' => 'nl',
                'language_parent' => NULL,
                'menu_id' => 1,
                'title' => 'Home',
                'slug' => 'home',
                'slug_lock' => 0,
                'type' => 'page',
                'is_home' => 1,
                'route' => NULL,
                'routename' => 'entity.pages.1.show.5',
                'route_has_auth' => 0,
                'entity_id' => 1,
                'entity_view_id' => 101,
                'object_id' => 5,
                'tag_id' => NULL,
                'url' => NULL,
                'locked_by_admin' => 1,
                'updated_at' => NULL,
                'created_at' => NULL,
                'publish' => 1,
                'parent_id' => NULL,
                'lft' => 1,
                'rgt' => 2,
                'depth' => 0,
                'position' => 1001,
            ),
        ));
        
        
    }
}