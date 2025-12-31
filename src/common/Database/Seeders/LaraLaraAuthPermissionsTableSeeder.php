<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraLaraAuthPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_auth_permissions')->delete();
        
        \DB::table('lara_auth_permissions')->insert(array (
            0 => 
            array (
                'id' => 99,
                'name' => 'view_any_blog',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            1 => 
            array (
                'id' => 100,
                'name' => 'view_blog',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            2 => 
            array (
                'id' => 101,
                'name' => 'create_blog',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            3 => 
            array (
                'id' => 102,
                'name' => 'update_blog',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            4 => 
            array (
                'id' => 103,
                'name' => 'delete_blog',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            5 => 
            array (
                'id' => 104,
                'name' => 'delete_any_blog',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            6 => 
            array (
                'id' => 105,
                'name' => 'view_any_team',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            7 => 
            array (
                'id' => 106,
                'name' => 'view_team',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            8 => 
            array (
                'id' => 107,
                'name' => 'create_team',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            9 => 
            array (
                'id' => 108,
                'name' => 'update_team',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            10 => 
            array (
                'id' => 109,
                'name' => 'delete_team',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            11 => 
            array (
                'id' => 110,
                'name' => 'delete_any_team',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            12 => 
            array (
                'id' => 111,
                'name' => 'view_any_location',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            13 => 
            array (
                'id' => 112,
                'name' => 'view_location',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            14 => 
            array (
                'id' => 113,
                'name' => 'create_location',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            15 => 
            array (
                'id' => 114,
                'name' => 'update_location',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            16 => 
            array (
                'id' => 115,
                'name' => 'delete_location',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            17 => 
            array (
                'id' => 116,
                'name' => 'delete_any_location',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            18 => 
            array (
                'id' => 117,
                'name' => 'view_any_slider',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            19 => 
            array (
                'id' => 118,
                'name' => 'view_slider',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            20 => 
            array (
                'id' => 119,
                'name' => 'create_slider',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            21 => 
            array (
                'id' => 120,
                'name' => 'update_slider',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            22 => 
            array (
                'id' => 121,
                'name' => 'delete_slider',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            23 => 
            array (
                'id' => 122,
                'name' => 'delete_any_slider',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            24 => 
            array (
                'id' => 123,
                'name' => 'view_any_contactform',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            25 => 
            array (
                'id' => 124,
                'name' => 'view_contactform',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            26 => 
            array (
                'id' => 125,
                'name' => 'create_contactform',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            27 => 
            array (
                'id' => 126,
                'name' => 'update_contactform',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            28 => 
            array (
                'id' => 127,
                'name' => 'delete_contactform',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            29 => 
            array (
                'id' => 128,
                'name' => 'delete_any_contactform',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            30 => 
            array (
                'id' => 129,
                'name' => 'view_any_entity',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            31 => 
            array (
                'id' => 130,
                'name' => 'view_entity',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            32 => 
            array (
                'id' => 131,
                'name' => 'create_entity',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            33 => 
            array (
                'id' => 132,
                'name' => 'update_entity',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            34 => 
            array (
                'id' => 133,
                'name' => 'delete_entity',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            35 => 
            array (
                'id' => 134,
                'name' => 'delete_any_entity',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            36 => 
            array (
                'id' => 135,
                'name' => 'view_any_menu',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            37 => 
            array (
                'id' => 136,
                'name' => 'view_menu',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            38 => 
            array (
                'id' => 137,
                'name' => 'create_menu',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            39 => 
            array (
                'id' => 138,
                'name' => 'update_menu',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            40 => 
            array (
                'id' => 139,
                'name' => 'delete_menu',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            41 => 
            array (
                'id' => 140,
                'name' => 'delete_any_menu',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            42 => 
            array (
                'id' => 141,
                'name' => 'view_any_menuitem',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            43 => 
            array (
                'id' => 142,
                'name' => 'view_menuitem',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            44 => 
            array (
                'id' => 143,
                'name' => 'create_menuitem',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            45 => 
            array (
                'id' => 144,
                'name' => 'update_menuitem',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            46 => 
            array (
                'id' => 145,
                'name' => 'delete_menuitem',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            47 => 
            array (
                'id' => 146,
                'name' => 'delete_any_menuitem',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            48 => 
            array (
                'id' => 147,
                'name' => 'view_any_page',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            49 => 
            array (
                'id' => 148,
                'name' => 'view_page',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            50 => 
            array (
                'id' => 149,
                'name' => 'create_page',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            51 => 
            array (
                'id' => 150,
                'name' => 'update_page',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            52 => 
            array (
                'id' => 151,
                'name' => 'delete_page',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            53 => 
            array (
                'id' => 152,
                'name' => 'delete_any_page',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            54 => 
            array (
                'id' => 153,
                'name' => 'view_any_setting',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            55 => 
            array (
                'id' => 154,
                'name' => 'view_setting',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            56 => 
            array (
                'id' => 155,
                'name' => 'create_setting',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            57 => 
            array (
                'id' => 156,
                'name' => 'update_setting',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            58 => 
            array (
                'id' => 157,
                'name' => 'delete_setting',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            59 => 
            array (
                'id' => 158,
                'name' => 'delete_any_setting',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            60 => 
            array (
                'id' => 159,
                'name' => 'view_any_translation',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            61 => 
            array (
                'id' => 160,
                'name' => 'view_translation',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            62 => 
            array (
                'id' => 161,
                'name' => 'create_translation',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            63 => 
            array (
                'id' => 162,
                'name' => 'update_translation',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            64 => 
            array (
                'id' => 163,
                'name' => 'delete_translation',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            65 => 
            array (
                'id' => 164,
                'name' => 'delete_any_translation',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            66 => 
            array (
                'id' => 165,
                'name' => 'view_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            67 => 
            array (
                'id' => 166,
                'name' => 'view_user',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            68 => 
            array (
                'id' => 167,
                'name' => 'create_user',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            69 => 
            array (
                'id' => 168,
                'name' => 'update_user',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            70 => 
            array (
                'id' => 169,
                'name' => 'delete_user',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            71 => 
            array (
                'id' => 170,
                'name' => 'delete_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            72 => 
            array (
                'id' => 171,
                'name' => 'view_any_role',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            73 => 
            array (
                'id' => 172,
                'name' => 'view_role',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            74 => 
            array (
                'id' => 173,
                'name' => 'create_role',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            75 => 
            array (
                'id' => 174,
                'name' => 'update_role',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            76 => 
            array (
                'id' => 175,
                'name' => 'delete_role',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            77 => 
            array (
                'id' => 176,
                'name' => 'delete_any_role',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            78 => 
            array (
                'id' => 177,
                'name' => 'view_any_cache',
                'guard_name' => 'web',
                'created_at' => '2025-07-08 14:47:20',
                'updated_at' => '2025-07-08 14:47:20',
            ),
            79 => 
            array (
                'id' => 178,
                'name' => 'view_any_event',
                'guard_name' => 'web',
                'created_at' => '2025-07-11 09:41:16',
                'updated_at' => '2025-07-11 09:41:16',
            ),
            80 => 
            array (
                'id' => 179,
                'name' => 'view_event',
                'guard_name' => 'web',
                'created_at' => '2025-07-11 09:41:16',
                'updated_at' => '2025-07-11 09:41:16',
            ),
            81 => 
            array (
                'id' => 180,
                'name' => 'create_event',
                'guard_name' => 'web',
                'created_at' => '2025-07-11 09:41:16',
                'updated_at' => '2025-07-11 09:41:16',
            ),
            82 => 
            array (
                'id' => 181,
                'name' => 'update_event',
                'guard_name' => 'web',
                'created_at' => '2025-07-11 09:41:16',
                'updated_at' => '2025-07-11 09:41:16',
            ),
            83 => 
            array (
                'id' => 182,
                'name' => 'delete_event',
                'guard_name' => 'web',
                'created_at' => '2025-07-11 09:41:16',
                'updated_at' => '2025-07-11 09:41:16',
            ),
            84 => 
            array (
                'id' => 183,
                'name' => 'delete_any_event',
                'guard_name' => 'web',
                'created_at' => '2025-07-11 09:41:16',
                'updated_at' => '2025-07-11 09:41:16',
            ),
            85 => 
            array (
                'id' => 184,
                'name' => 'view_any_widget',
                'guard_name' => 'web',
                'created_at' => '2025-07-11 09:41:16',
                'updated_at' => '2025-07-11 09:41:16',
            ),
            86 => 
            array (
                'id' => 185,
                'name' => 'view_widget',
                'guard_name' => 'web',
                'created_at' => '2025-07-11 09:41:16',
                'updated_at' => '2025-07-11 09:41:16',
            ),
            87 => 
            array (
                'id' => 186,
                'name' => 'create_widget',
                'guard_name' => 'web',
                'created_at' => '2025-07-11 09:41:16',
                'updated_at' => '2025-07-11 09:41:16',
            ),
            88 => 
            array (
                'id' => 187,
                'name' => 'update_widget',
                'guard_name' => 'web',
                'created_at' => '2025-07-11 09:41:16',
                'updated_at' => '2025-07-11 09:41:16',
            ),
            89 => 
            array (
                'id' => 188,
                'name' => 'delete_widget',
                'guard_name' => 'web',
                'created_at' => '2025-07-11 09:41:16',
                'updated_at' => '2025-07-11 09:41:16',
            ),
            90 => 
            array (
                'id' => 189,
                'name' => 'delete_any_widget',
                'guard_name' => 'web',
                'created_at' => '2025-07-11 09:41:16',
                'updated_at' => '2025-07-11 09:41:16',
            ),
            91 => 
            array (
                'id' => 190,
                'name' => 'view_any_cta',
                'guard_name' => 'web',
                'created_at' => '2025-08-14 14:23:42',
                'updated_at' => '2025-08-14 14:23:42',
            ),
            92 => 
            array (
                'id' => 191,
                'name' => 'view_cta',
                'guard_name' => 'web',
                'created_at' => '2025-08-14 14:23:42',
                'updated_at' => '2025-08-14 14:23:42',
            ),
            93 => 
            array (
                'id' => 192,
                'name' => 'create_cta',
                'guard_name' => 'web',
                'created_at' => '2025-08-14 14:23:42',
                'updated_at' => '2025-08-14 14:23:42',
            ),
            94 => 
            array (
                'id' => 193,
                'name' => 'update_cta',
                'guard_name' => 'web',
                'created_at' => '2025-08-14 14:23:42',
                'updated_at' => '2025-08-14 14:23:42',
            ),
            95 => 
            array (
                'id' => 194,
                'name' => 'delete_cta',
                'guard_name' => 'web',
                'created_at' => '2025-08-14 14:23:42',
                'updated_at' => '2025-08-14 14:23:42',
            ),
            96 => 
            array (
                'id' => 195,
                'name' => 'delete_any_cta',
                'guard_name' => 'web',
                'created_at' => '2025-08-14 14:23:42',
                'updated_at' => '2025-08-14 14:23:42',
            ),
            97 => 
            array (
                'id' => 196,
                'name' => 'view_any_larawidget',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            98 => 
            array (
                'id' => 197,
                'name' => 'view_larawidget',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            99 => 
            array (
                'id' => 198,
                'name' => 'create_larawidget',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            100 => 
            array (
                'id' => 199,
                'name' => 'update_larawidget',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            101 => 
            array (
                'id' => 200,
                'name' => 'delete_larawidget',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            102 => 
            array (
                'id' => 201,
                'name' => 'delete_any_larawidget',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            103 => 
            array (
                'id' => 202,
                'name' => 'view_any_service',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            104 => 
            array (
                'id' => 203,
                'name' => 'view_service',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            105 => 
            array (
                'id' => 204,
                'name' => 'create_service',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            106 => 
            array (
                'id' => 205,
                'name' => 'update_service',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            107 => 
            array (
                'id' => 206,
                'name' => 'delete_service',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            108 => 
            array (
                'id' => 207,
                'name' => 'delete_any_service',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            109 => 
            array (
                'id' => 208,
                'name' => 'view_any_testimonial',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            110 => 
            array (
                'id' => 209,
                'name' => 'view_testimonial',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            111 => 
            array (
                'id' => 210,
                'name' => 'create_testimonial',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            112 => 
            array (
                'id' => 211,
                'name' => 'update_testimonial',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            113 => 
            array (
                'id' => 212,
                'name' => 'delete_testimonial',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            114 => 
            array (
                'id' => 213,
                'name' => 'delete_any_testimonial',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            115 => 
            array (
                'id' => 214,
                'name' => 'view_any_portfolio',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            116 => 
            array (
                'id' => 215,
                'name' => 'view_portfolio',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            117 => 
            array (
                'id' => 216,
                'name' => 'create_portfolio',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            118 => 
            array (
                'id' => 217,
                'name' => 'update_portfolio',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            119 => 
            array (
                'id' => 218,
                'name' => 'delete_portfolio',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            120 => 
            array (
                'id' => 219,
                'name' => 'delete_any_portfolio',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            121 => 
            array (
                'id' => 220,
                'name' => 'view_any_gallery',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            122 => 
            array (
                'id' => 221,
                'name' => 'view_gallery',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            123 => 
            array (
                'id' => 222,
                'name' => 'create_gallery',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            124 => 
            array (
                'id' => 223,
                'name' => 'update_gallery',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            125 => 
            array (
                'id' => 224,
                'name' => 'delete_gallery',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            126 => 
            array (
                'id' => 225,
                'name' => 'delete_any_gallery',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            127 => 
            array (
                'id' => 226,
                'name' => 'view_any_doc',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            128 => 
            array (
                'id' => 227,
                'name' => 'view_doc',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            129 => 
            array (
                'id' => 228,
                'name' => 'create_doc',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            130 => 
            array (
                'id' => 229,
                'name' => 'update_doc',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            131 => 
            array (
                'id' => 230,
                'name' => 'delete_doc',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            132 => 
            array (
                'id' => 231,
                'name' => 'delete_any_doc',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            133 => 
            array (
                'id' => 232,
                'name' => 'view_any_video',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            134 => 
            array (
                'id' => 233,
                'name' => 'view_video',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            135 => 
            array (
                'id' => 234,
                'name' => 'create_video',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            136 => 
            array (
                'id' => 235,
                'name' => 'update_video',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            137 => 
            array (
                'id' => 236,
                'name' => 'delete_video',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            138 => 
            array (
                'id' => 237,
                'name' => 'delete_any_video',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            139 => 
            array (
                'id' => 238,
                'name' => 'view_any_classicform',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            140 => 
            array (
                'id' => 239,
                'name' => 'view_classicform',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            141 => 
            array (
                'id' => 240,
                'name' => 'create_classicform',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            142 => 
            array (
                'id' => 241,
                'name' => 'update_classicform',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            143 => 
            array (
                'id' => 242,
                'name' => 'delete_classicform',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            144 => 
            array (
                'id' => 243,
                'name' => 'delete_any_classicform',
                'guard_name' => 'web',
                'created_at' => '2025-09-28 09:05:50',
                'updated_at' => '2025-09-28 09:05:50',
            ),
            145 => 
            array (
                'id' => 244,
                'name' => 'view_any_product',
                'guard_name' => 'web',
                'created_at' => '2025-10-22 13:55:53',
                'updated_at' => '2025-10-22 13:55:53',
            ),
            146 => 
            array (
                'id' => 245,
                'name' => 'view_product',
                'guard_name' => 'web',
                'created_at' => '2025-10-22 13:55:53',
                'updated_at' => '2025-10-22 13:55:53',
            ),
            147 => 
            array (
                'id' => 246,
                'name' => 'create_product',
                'guard_name' => 'web',
                'created_at' => '2025-10-22 13:55:53',
                'updated_at' => '2025-10-22 13:55:53',
            ),
            148 => 
            array (
                'id' => 247,
                'name' => 'update_product',
                'guard_name' => 'web',
                'created_at' => '2025-10-22 13:55:53',
                'updated_at' => '2025-10-22 13:55:53',
            ),
            149 => 
            array (
                'id' => 248,
                'name' => 'delete_product',
                'guard_name' => 'web',
                'created_at' => '2025-10-22 13:55:53',
                'updated_at' => '2025-10-22 13:55:53',
            ),
            150 => 
            array (
                'id' => 249,
                'name' => 'delete_any_product',
                'guard_name' => 'web',
                'created_at' => '2025-10-22 13:55:53',
                'updated_at' => '2025-10-22 13:55:53',
            ),
            151 => 
            array (
                'id' => 250,
                'name' => 'view_any_city',
                'guard_name' => 'web',
                'created_at' => '2025-10-22 13:55:53',
                'updated_at' => '2025-10-22 13:55:53',
            ),
            152 => 
            array (
                'id' => 251,
                'name' => 'view_city',
                'guard_name' => 'web',
                'created_at' => '2025-10-22 13:55:53',
                'updated_at' => '2025-10-22 13:55:53',
            ),
            153 => 
            array (
                'id' => 252,
                'name' => 'create_city',
                'guard_name' => 'web',
                'created_at' => '2025-10-22 13:55:53',
                'updated_at' => '2025-10-22 13:55:53',
            ),
            154 => 
            array (
                'id' => 253,
                'name' => 'update_city',
                'guard_name' => 'web',
                'created_at' => '2025-10-22 13:55:53',
                'updated_at' => '2025-10-22 13:55:53',
            ),
            155 => 
            array (
                'id' => 254,
                'name' => 'delete_city',
                'guard_name' => 'web',
                'created_at' => '2025-10-22 13:55:53',
                'updated_at' => '2025-10-22 13:55:53',
            ),
            156 => 
            array (
                'id' => 255,
                'name' => 'delete_any_city',
                'guard_name' => 'web',
                'created_at' => '2025-10-22 13:55:53',
                'updated_at' => '2025-10-22 13:55:53',
            ),
            157 => 
            array (
                'id' => 256,
                'name' => 'view_any_media',
                'guard_name' => 'web',
                'created_at' => '2025-12-17 19:17:03',
                'updated_at' => '2025-12-17 19:17:03',
            ),
            158 => 
            array (
                'id' => 257,
                'name' => 'view_media',
                'guard_name' => 'web',
                'created_at' => '2025-12-17 19:17:03',
                'updated_at' => '2025-12-17 19:17:03',
            ),
            159 => 
            array (
                'id' => 258,
                'name' => 'create_media',
                'guard_name' => 'web',
                'created_at' => '2025-12-17 19:17:03',
                'updated_at' => '2025-12-17 19:17:03',
            ),
            160 => 
            array (
                'id' => 259,
                'name' => 'update_media',
                'guard_name' => 'web',
                'created_at' => '2025-12-17 19:17:03',
                'updated_at' => '2025-12-17 19:17:03',
            ),
            161 => 
            array (
                'id' => 260,
                'name' => 'delete_media',
                'guard_name' => 'web',
                'created_at' => '2025-12-17 19:17:03',
                'updated_at' => '2025-12-17 19:17:03',
            ),
            162 => 
            array (
                'id' => 261,
                'name' => 'delete_any_media',
                'guard_name' => 'web',
                'created_at' => '2025-12-17 19:17:03',
                'updated_at' => '2025-12-17 19:17:03',
            ),
            163 => 
            array (
                'id' => 262,
                'name' => 'view any_media',
                'guard_name' => 'web',
                'created_at' => '2025-12-17 19:20:09',
                'updated_at' => '2025-12-17 19:20:09',
            ),
        ));
        
        
    }
}