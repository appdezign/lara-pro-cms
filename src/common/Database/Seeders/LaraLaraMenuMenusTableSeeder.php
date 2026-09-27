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

        \DB::table('lara_menu_menus')->insert([
            0 => [
                'id' => 1,
                'title' => 'Main',
                'slug' => 'main',
                'created_at' => '2025-04-22 14:57:57',
                'updated_at' => '2026-09-26 15:37:18',
                'locked_at' => null,
                'locked_by' => null,
            ],
            1 => [
                'id' => 2,
                'title' => 'Top',
                'slug' => 'top',
                'created_at' => '2025-04-22 15:08:00',
                'updated_at' => '2026-01-25 16:49:48',
                'locked_at' => null,
                'locked_by' => null,
            ],
        ]);

    }
}
