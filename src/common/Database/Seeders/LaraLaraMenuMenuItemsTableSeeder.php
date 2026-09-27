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

        \DB::table('lara_menu_menu_items')->insert([
            0 => [
                'id' => 1,
                'language' => 'nl',
                'language_parent' => null,
                'menu_id' => 1,
                'title' => 'Home',
                'slug' => 'home',
                'slug_lock' => 0,
                'type' => 'page',
                'is_home' => 1,
                'route' => null,
                'routename' => 'entity.pages.1.show.5',
                'route_has_auth' => 0,
                'entity_id' => 1,
                'entity_view_id' => 101,
                'object_id' => 5,
                'tag_id' => null,
                'url' => null,
                'locked_by_admin' => 1,
                'updated_at' => null,
                'created_at' => null,
                'publish' => 1,
                'parent_id' => null,
                'lft' => 1,
                'rgt' => 2,
                'depth' => 0,
                'position' => 1001,
                'locked_at' => null,
                'locked_by' => null,
            ],
            1 => [
                'id' => 114,
                'language' => 'en',
                'language_parent' => null,
                'menu_id' => 1,
                'title' => '[en] home',
                'slug' => 'en-home',
                'slug_lock' => 0,
                'type' => 'page',
                'is_home' => 1,
                'route' => null,
                'routename' => 'entity.pages.114.show.19',
                'route_has_auth' => 0,
                'entity_id' => 1,
                'entity_view_id' => 101,
                'object_id' => 19,
                'tag_id' => null,
                'url' => null,
                'locked_by_admin' => 1,
                'updated_at' => null,
                'created_at' => null,
                'publish' => 1,
                'parent_id' => null,
                'lft' => 1,
                'rgt' => 2,
                'depth' => 0,
                'position' => 1001,
                'locked_at' => null,
                'locked_by' => null,
            ],
        ]);

    }
}
