<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraAuthPermissionsTableSeeder extends Seeder
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
        ));
        
        
    }
}