<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraLaraMenuMenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_menu_menus')->delete();
        
        \DB::table('lara_menu_menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Main',
                'slug' => 'main',
                'created_at' => '2025-04-22 14:57:57',
                'updated_at' => '2026-03-19 17:35:33',
                'locked_at' => NULL,
                'locked_by' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Top',
                'slug' => 'top',
                'created_at' => '2025-04-22 15:08:00',
                'updated_at' => '2026-01-25 16:49:48',
                'locked_at' => NULL,
                'locked_by' => NULL,
            ),
        ));
        
        
    }
}