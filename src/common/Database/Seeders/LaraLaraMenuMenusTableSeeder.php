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
                'updated_at' => '2025-10-25 17:11:48',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Top',
                'slug' => 'top',
                'created_at' => '2025-04-22 15:08:00',
                'updated_at' => '2025-09-12 19:09:14',
            ),
        ));
        
        
    }
}