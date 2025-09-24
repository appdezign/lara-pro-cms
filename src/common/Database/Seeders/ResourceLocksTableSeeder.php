<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ResourceLocksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('resource_locks')->delete();
        
        \DB::table('resource_locks')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => '2025-08-14 14:22:14',
                'updated_at' => '2025-08-14 14:22:14',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            1 => 
            array (
                'id' => 5,
                'created_at' => '2025-08-14 14:22:44',
                'updated_at' => '2025-08-14 14:22:44',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            2 => 
            array (
                'id' => 7,
                'created_at' => '2025-08-14 14:24:35',
                'updated_at' => '2025-08-14 14:24:35',
                'user_id' => 1,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            3 => 
            array (
                'id' => 8,
                'created_at' => '2025-08-14 14:24:47',
                'updated_at' => '2025-08-14 14:24:47',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            4 => 
            array (
                'id' => 9,
                'created_at' => '2025-08-14 14:24:58',
                'updated_at' => '2025-08-14 14:24:58',
                'user_id' => 1,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            5 => 
            array (
                'id' => 10,
                'created_at' => '2025-08-14 14:25:10',
                'updated_at' => '2025-08-14 14:25:10',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            6 => 
            array (
                'id' => 12,
                'created_at' => '2025-08-15 09:56:21',
                'updated_at' => '2025-08-15 09:56:21',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            7 => 
            array (
                'id' => 13,
                'created_at' => '2025-08-15 10:53:43',
                'updated_at' => '2025-08-15 10:53:43',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 5,
            ),
            8 => 
            array (
                'id' => 14,
                'created_at' => '2025-08-20 12:54:15',
                'updated_at' => '2025-08-20 12:54:15',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            9 => 
            array (
                'id' => 17,
                'created_at' => '2025-08-20 12:55:46',
                'updated_at' => '2025-08-20 12:55:46',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            10 => 
            array (
                'id' => 19,
                'created_at' => '2025-08-20 12:59:08',
                'updated_at' => '2025-08-20 12:59:08',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            11 => 
            array (
                'id' => 20,
                'created_at' => '2025-08-20 13:00:34',
                'updated_at' => '2025-08-20 13:00:34',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            12 => 
            array (
                'id' => 21,
                'created_at' => '2025-08-20 13:31:38',
                'updated_at' => '2025-08-20 13:31:38',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            13 => 
            array (
                'id' => 22,
                'created_at' => '2025-08-20 13:34:00',
                'updated_at' => '2025-08-20 13:34:00',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            14 => 
            array (
                'id' => 26,
                'created_at' => '2025-08-20 13:36:15',
                'updated_at' => '2025-08-20 13:36:15',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            15 => 
            array (
                'id' => 29,
                'created_at' => '2025-08-20 13:37:48',
                'updated_at' => '2025-08-20 13:37:48',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            16 => 
            array (
                'id' => 32,
                'created_at' => '2025-08-20 13:41:32',
                'updated_at' => '2025-08-20 13:41:32',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            17 => 
            array (
                'id' => 37,
                'created_at' => '2025-08-20 13:42:22',
                'updated_at' => '2025-08-20 13:42:22',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            18 => 
            array (
                'id' => 38,
                'created_at' => '2025-08-20 13:43:09',
                'updated_at' => '2025-08-20 13:43:09',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            19 => 
            array (
                'id' => 41,
                'created_at' => '2025-08-20 13:46:30',
                'updated_at' => '2025-08-20 13:46:30',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            20 => 
            array (
                'id' => 42,
                'created_at' => '2025-08-20 13:47:19',
                'updated_at' => '2025-08-20 13:47:19',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            21 => 
            array (
                'id' => 43,
                'created_at' => '2025-08-20 13:53:21',
                'updated_at' => '2025-08-20 13:53:21',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            22 => 
            array (
                'id' => 44,
                'created_at' => '2025-08-20 13:56:48',
                'updated_at' => '2025-08-20 13:56:48',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            23 => 
            array (
                'id' => 46,
                'created_at' => '2025-08-20 14:03:36',
                'updated_at' => '2025-08-20 14:03:36',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            24 => 
            array (
                'id' => 48,
                'created_at' => '2025-08-20 14:03:53',
                'updated_at' => '2025-08-20 14:03:53',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            25 => 
            array (
                'id' => 49,
                'created_at' => '2025-08-20 14:04:21',
                'updated_at' => '2025-08-20 14:04:21',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            26 => 
            array (
                'id' => 51,
                'created_at' => '2025-08-20 14:04:55',
                'updated_at' => '2025-08-20 14:04:55',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            27 => 
            array (
                'id' => 53,
                'created_at' => '2025-08-20 14:06:23',
                'updated_at' => '2025-08-20 14:06:23',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            28 => 
            array (
                'id' => 56,
                'created_at' => '2025-08-20 14:18:32',
                'updated_at' => '2025-08-20 14:18:32',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            29 => 
            array (
                'id' => 60,
                'created_at' => '2025-08-20 14:40:17',
                'updated_at' => '2025-08-20 14:40:17',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            30 => 
            array (
                'id' => 63,
                'created_at' => '2025-08-21 14:23:50',
                'updated_at' => '2025-08-21 14:23:50',
                'user_id' => 1,
                'lockable_type' => 'Lara\\App\\Models\\Team',
                'lockable_id' => 1,
            ),
            31 => 
            array (
                'id' => 66,
                'created_at' => '2025-08-21 14:24:17',
                'updated_at' => '2025-08-21 14:24:17',
                'user_id' => 1,
                'lockable_type' => 'Lara\\App\\Models\\Team',
                'lockable_id' => 1,
            ),
            32 => 
            array (
                'id' => 68,
                'created_at' => '2025-08-21 14:26:57',
                'updated_at' => '2025-08-21 14:26:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            33 => 
            array (
                'id' => 72,
                'created_at' => '2025-08-22 17:52:55',
                'updated_at' => '2025-08-22 17:52:55',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Service',
                'lockable_id' => 1,
            ),
            34 => 
            array (
                'id' => 74,
                'created_at' => '2025-08-22 17:53:20',
                'updated_at' => '2025-08-22 17:53:20',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Service',
                'lockable_id' => 1,
            ),
            35 => 
            array (
                'id' => 75,
                'created_at' => '2025-08-22 18:31:05',
                'updated_at' => '2025-08-22 18:31:05',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Service',
                'lockable_id' => 1,
            ),
            36 => 
            array (
                'id' => 76,
                'created_at' => '2025-08-22 18:35:14',
                'updated_at' => '2025-08-22 18:35:14',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Service',
                'lockable_id' => 1,
            ),
            37 => 
            array (
                'id' => 77,
                'created_at' => '2025-08-22 18:39:17',
                'updated_at' => '2025-08-22 18:39:17',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Service',
                'lockable_id' => 1,
            ),
            38 => 
            array (
                'id' => 79,
                'created_at' => '2025-08-22 18:43:35',
                'updated_at' => '2025-08-22 18:43:35',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Service',
                'lockable_id' => 1,
            ),
            39 => 
            array (
                'id' => 80,
                'created_at' => '2025-08-22 18:44:20',
                'updated_at' => '2025-08-22 18:44:20',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Service',
                'lockable_id' => 2,
            ),
            40 => 
            array (
                'id' => 81,
                'created_at' => '2025-08-22 18:48:21',
                'updated_at' => '2025-08-22 18:48:21',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Service',
                'lockable_id' => 1,
            ),
            41 => 
            array (
                'id' => 82,
                'created_at' => '2025-08-22 18:49:09',
                'updated_at' => '2025-08-22 18:49:09',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Service',
                'lockable_id' => 3,
            ),
            42 => 
            array (
                'id' => 83,
                'created_at' => '2025-08-24 11:41:47',
                'updated_at' => '2025-08-24 11:41:47',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            43 => 
            array (
                'id' => 84,
                'created_at' => '2025-08-24 11:43:05',
                'updated_at' => '2025-08-24 11:43:05',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            44 => 
            array (
                'id' => 85,
                'created_at' => '2025-08-24 11:45:09',
                'updated_at' => '2025-08-24 11:45:09',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            45 => 
            array (
                'id' => 86,
                'created_at' => '2025-08-24 11:45:45',
                'updated_at' => '2025-08-24 11:45:45',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            46 => 
            array (
                'id' => 87,
                'created_at' => '2025-08-24 11:47:31',
                'updated_at' => '2025-08-24 11:47:31',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            47 => 
            array (
                'id' => 89,
                'created_at' => '2025-08-24 11:52:50',
                'updated_at' => '2025-08-24 11:52:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            48 => 
            array (
                'id' => 92,
                'created_at' => '2025-08-24 12:38:25',
                'updated_at' => '2025-08-24 12:38:25',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Testimonial',
                'lockable_id' => 1,
            ),
            49 => 
            array (
                'id' => 93,
                'created_at' => '2025-08-24 12:40:03',
                'updated_at' => '2025-08-24 12:40:03',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Testimonial',
                'lockable_id' => 1,
            ),
            50 => 
            array (
                'id' => 94,
                'created_at' => '2025-08-24 12:44:02',
                'updated_at' => '2025-08-24 12:44:02',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Testimonial',
                'lockable_id' => 1,
            ),
            51 => 
            array (
                'id' => 95,
                'created_at' => '2025-08-24 12:44:38',
                'updated_at' => '2025-08-24 12:44:38',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Testimonial',
                'lockable_id' => 2,
            ),
            52 => 
            array (
                'id' => 97,
                'created_at' => '2025-08-24 12:46:30',
                'updated_at' => '2025-08-24 12:46:30',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Testimonial',
                'lockable_id' => 3,
            ),
            53 => 
            array (
                'id' => 98,
                'created_at' => '2025-08-24 12:48:18',
                'updated_at' => '2025-08-24 12:48:18',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Testimonial',
                'lockable_id' => 3,
            ),
            54 => 
            array (
                'id' => 99,
                'created_at' => '2025-08-24 12:48:53',
                'updated_at' => '2025-08-24 12:48:53',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Testimonial',
                'lockable_id' => 4,
            ),
            55 => 
            array (
                'id' => 100,
                'created_at' => '2025-08-24 12:51:01',
                'updated_at' => '2025-08-24 12:51:01',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Testimonial',
                'lockable_id' => 5,
            ),
            56 => 
            array (
                'id' => 101,
                'created_at' => '2025-08-24 12:51:21',
                'updated_at' => '2025-08-24 12:51:21',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Testimonial',
                'lockable_id' => 5,
            ),
            57 => 
            array (
                'id' => 102,
                'created_at' => '2025-08-24 12:52:56',
                'updated_at' => '2025-08-24 12:52:56',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Testimonial',
                'lockable_id' => 6,
            ),
            58 => 
            array (
                'id' => 103,
                'created_at' => '2025-08-24 13:07:21',
                'updated_at' => '2025-08-24 13:07:21',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            59 => 
            array (
                'id' => 106,
                'created_at' => '2025-08-24 13:11:50',
                'updated_at' => '2025-08-24 13:11:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Portfolio',
                'lockable_id' => 1,
            ),
            60 => 
            array (
                'id' => 108,
                'created_at' => '2025-08-24 13:13:43',
                'updated_at' => '2025-08-24 13:13:43',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Portfolio',
                'lockable_id' => 3,
            ),
            61 => 
            array (
                'id' => 112,
                'created_at' => '2025-08-24 13:14:18',
                'updated_at' => '2025-08-24 13:14:18',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Portfolio',
                'lockable_id' => 7,
            ),
            62 => 
            array (
                'id' => 113,
                'created_at' => '2025-08-24 13:14:35',
                'updated_at' => '2025-08-24 13:14:35',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Portfolio',
                'lockable_id' => 1,
            ),
            63 => 
            array (
                'id' => 114,
                'created_at' => '2025-08-24 13:15:36',
                'updated_at' => '2025-08-24 13:15:36',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Portfolio',
                'lockable_id' => 2,
            ),
            64 => 
            array (
                'id' => 115,
                'created_at' => '2025-08-24 13:15:55',
                'updated_at' => '2025-08-24 13:15:55',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Portfolio',
                'lockable_id' => 3,
            ),
            65 => 
            array (
                'id' => 116,
                'created_at' => '2025-08-24 13:16:11',
                'updated_at' => '2025-08-24 13:16:11',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Portfolio',
                'lockable_id' => 4,
            ),
            66 => 
            array (
                'id' => 117,
                'created_at' => '2025-08-24 13:16:32',
                'updated_at' => '2025-08-24 13:16:32',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Portfolio',
                'lockable_id' => 5,
            ),
            67 => 
            array (
                'id' => 118,
                'created_at' => '2025-08-24 13:16:48',
                'updated_at' => '2025-08-24 13:16:48',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Portfolio',
                'lockable_id' => 6,
            ),
            68 => 
            array (
                'id' => 119,
                'created_at' => '2025-08-24 13:17:10',
                'updated_at' => '2025-08-24 13:17:10',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Portfolio',
                'lockable_id' => 7,
            ),
            69 => 
            array (
                'id' => 120,
                'created_at' => '2025-08-24 18:40:28',
                'updated_at' => '2025-08-24 18:40:28',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 5,
            ),
            70 => 
            array (
                'id' => 121,
                'created_at' => '2025-08-24 18:40:42',
                'updated_at' => '2025-08-24 18:40:42',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            71 => 
            array (
                'id' => 123,
                'created_at' => '2025-08-25 07:51:27',
                'updated_at' => '2025-08-25 07:51:27',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Slider',
                'lockable_id' => 2,
            ),
            72 => 
            array (
                'id' => 124,
                'created_at' => '2025-08-25 07:52:30',
                'updated_at' => '2025-08-25 07:52:30',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Slider',
                'lockable_id' => 3,
            ),
            73 => 
            array (
                'id' => 125,
                'created_at' => '2025-08-25 07:52:50',
                'updated_at' => '2025-08-25 07:52:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Slider',
                'lockable_id' => 4,
            ),
            74 => 
            array (
                'id' => 126,
                'created_at' => '2025-08-25 07:54:20',
                'updated_at' => '2025-08-25 07:54:20',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 5,
            ),
            75 => 
            array (
                'id' => 128,
                'created_at' => '2025-08-25 08:46:46',
                'updated_at' => '2025-08-25 08:46:46',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Slider',
                'lockable_id' => 2,
            ),
            76 => 
            array (
                'id' => 129,
                'created_at' => '2025-08-25 08:47:32',
                'updated_at' => '2025-08-25 08:47:32',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Slider',
                'lockable_id' => 2,
            ),
            77 => 
            array (
                'id' => 130,
                'created_at' => '2025-08-25 08:56:50',
                'updated_at' => '2025-08-25 08:56:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 5,
            ),
            78 => 
            array (
                'id' => 132,
                'created_at' => '2025-08-25 09:08:11',
                'updated_at' => '2025-08-25 09:08:11',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 3,
            ),
            79 => 
            array (
                'id' => 133,
                'created_at' => '2025-08-25 09:08:54',
                'updated_at' => '2025-08-25 09:08:54',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 3,
            ),
            80 => 
            array (
                'id' => 135,
                'created_at' => '2025-08-25 09:09:29',
                'updated_at' => '2025-08-25 09:09:29',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 3,
            ),
            81 => 
            array (
                'id' => 136,
                'created_at' => '2025-08-25 09:13:15',
                'updated_at' => '2025-08-25 09:13:15',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 3,
            ),
            82 => 
            array (
                'id' => 137,
                'created_at' => '2025-08-25 09:14:53',
                'updated_at' => '2025-08-25 09:14:53',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 3,
            ),
            83 => 
            array (
                'id' => 139,
                'created_at' => '2025-08-25 09:15:56',
                'updated_at' => '2025-08-25 09:15:56',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 3,
            ),
            84 => 
            array (
                'id' => 140,
                'created_at' => '2025-08-25 09:16:28',
                'updated_at' => '2025-08-25 09:16:28',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 3,
            ),
            85 => 
            array (
                'id' => 141,
                'created_at' => '2025-08-25 09:21:51',
                'updated_at' => '2025-08-25 09:21:51',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 3,
            ),
            86 => 
            array (
                'id' => 142,
                'created_at' => '2025-08-25 09:24:32',
                'updated_at' => '2025-08-25 09:24:32',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 3,
            ),
            87 => 
            array (
                'id' => 143,
                'created_at' => '2025-08-25 09:28:47',
                'updated_at' => '2025-08-25 09:28:47',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 4,
            ),
            88 => 
            array (
                'id' => 144,
                'created_at' => '2025-08-25 09:30:03',
                'updated_at' => '2025-08-25 09:30:03',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 5,
            ),
            89 => 
            array (
                'id' => 145,
                'created_at' => '2025-08-25 09:30:29',
                'updated_at' => '2025-08-25 09:30:29',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 4,
            ),
            90 => 
            array (
                'id' => 147,
                'created_at' => '2025-08-25 09:32:02',
                'updated_at' => '2025-08-25 09:32:02',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 6,
            ),
            91 => 
            array (
                'id' => 148,
                'created_at' => '2025-08-25 09:32:24',
                'updated_at' => '2025-08-25 09:32:24',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 6,
            ),
            92 => 
            array (
                'id' => 149,
                'created_at' => '2025-08-25 09:32:52',
                'updated_at' => '2025-08-25 09:32:52',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 6,
            ),
            93 => 
            array (
                'id' => 151,
                'created_at' => '2025-08-25 10:31:16',
                'updated_at' => '2025-08-25 10:31:16',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Slider',
                'lockable_id' => 5,
            ),
            94 => 
            array (
                'id' => 153,
                'created_at' => '2025-08-25 10:35:39',
                'updated_at' => '2025-08-25 10:35:39',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Slider',
                'lockable_id' => 6,
            ),
            95 => 
            array (
                'id' => 154,
                'created_at' => '2025-08-25 10:36:49',
                'updated_at' => '2025-08-25 10:36:49',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Slider',
                'lockable_id' => 6,
            ),
            96 => 
            array (
                'id' => 157,
                'created_at' => '2025-08-25 10:39:18',
                'updated_at' => '2025-08-25 10:39:18',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Service',
                'lockable_id' => 1,
            ),
            97 => 
            array (
                'id' => 158,
                'created_at' => '2025-08-25 11:22:37',
                'updated_at' => '2025-08-25 11:22:37',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 7,
            ),
            98 => 
            array (
                'id' => 159,
                'created_at' => '2025-08-25 11:23:16',
                'updated_at' => '2025-08-25 11:23:16',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 7,
            ),
            99 => 
            array (
                'id' => 160,
                'created_at' => '2025-08-25 11:24:48',
                'updated_at' => '2025-08-25 11:24:48',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 8,
            ),
            100 => 
            array (
                'id' => 161,
                'created_at' => '2025-08-25 11:27:46',
                'updated_at' => '2025-08-25 11:27:46',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 8,
            ),
            101 => 
            array (
                'id' => 166,
                'created_at' => '2025-08-25 11:35:32',
                'updated_at' => '2025-08-25 11:35:32',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 9,
            ),
            102 => 
            array (
                'id' => 167,
                'created_at' => '2025-08-25 11:36:59',
                'updated_at' => '2025-08-25 11:36:59',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 9,
            ),
            103 => 
            array (
                'id' => 169,
                'created_at' => '2025-08-25 12:07:14',
                'updated_at' => '2025-08-25 12:07:14',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            104 => 
            array (
                'id' => 170,
                'created_at' => '2025-08-25 12:08:50',
                'updated_at' => '2025-08-25 12:08:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            105 => 
            array (
                'id' => 171,
                'created_at' => '2025-08-25 12:10:49',
                'updated_at' => '2025-08-25 12:10:49',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            106 => 
            array (
                'id' => 172,
                'created_at' => '2025-08-25 12:11:48',
                'updated_at' => '2025-08-25 12:11:48',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 29,
            ),
            107 => 
            array (
                'id' => 173,
                'created_at' => '2025-08-25 12:12:52',
                'updated_at' => '2025-08-25 12:12:52',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 22,
            ),
            108 => 
            array (
                'id' => 174,
                'created_at' => '2025-08-25 12:13:23',
                'updated_at' => '2025-08-25 12:13:23',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 27,
            ),
            109 => 
            array (
                'id' => 175,
                'created_at' => '2025-08-25 12:13:57',
                'updated_at' => '2025-08-25 12:13:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 26,
            ),
            110 => 
            array (
                'id' => 176,
                'created_at' => '2025-08-25 12:14:24',
                'updated_at' => '2025-08-25 12:14:24',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 25,
            ),
            111 => 
            array (
                'id' => 177,
                'created_at' => '2025-08-25 12:15:19',
                'updated_at' => '2025-08-25 12:15:19',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 24,
            ),
            112 => 
            array (
                'id' => 178,
                'created_at' => '2025-08-25 12:15:43',
                'updated_at' => '2025-08-25 12:15:43',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 23,
            ),
            113 => 
            array (
                'id' => 179,
                'created_at' => '2025-08-25 12:16:11',
                'updated_at' => '2025-08-25 12:16:11',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 23,
            ),
            114 => 
            array (
                'id' => 180,
                'created_at' => '2025-08-25 12:16:36',
                'updated_at' => '2025-08-25 12:16:36',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            115 => 
            array (
                'id' => 181,
                'created_at' => '2025-08-25 15:49:59',
                'updated_at' => '2025-08-25 15:49:59',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            116 => 
            array (
                'id' => 183,
                'created_at' => '2025-08-29 12:25:28',
                'updated_at' => '2025-08-29 12:25:28',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Gallery',
                'lockable_id' => 1,
            ),
            117 => 
            array (
                'id' => 184,
                'created_at' => '2025-08-29 12:28:05',
                'updated_at' => '2025-08-29 12:28:05',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Gallery',
                'lockable_id' => 1,
            ),
            118 => 
            array (
                'id' => 185,
                'created_at' => '2025-08-29 12:30:31',
                'updated_at' => '2025-08-29 12:30:31',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Gallery',
                'lockable_id' => 1,
            ),
            119 => 
            array (
                'id' => 186,
                'created_at' => '2025-08-29 12:32:13',
                'updated_at' => '2025-08-29 12:32:13',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Gallery',
                'lockable_id' => 2,
            ),
            120 => 
            array (
                'id' => 187,
                'created_at' => '2025-08-29 13:21:58',
                'updated_at' => '2025-08-29 13:21:58',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 1,
            ),
            121 => 
            array (
                'id' => 188,
                'created_at' => '2025-08-29 13:23:26',
                'updated_at' => '2025-08-29 13:23:26',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 1,
            ),
            122 => 
            array (
                'id' => 189,
                'created_at' => '2025-08-29 13:25:18',
                'updated_at' => '2025-08-29 13:25:18',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 1,
            ),
            123 => 
            array (
                'id' => 190,
                'created_at' => '2025-08-29 13:25:57',
                'updated_at' => '2025-08-29 13:25:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 1,
            ),
            124 => 
            array (
                'id' => 197,
                'created_at' => '2025-08-29 13:33:37',
                'updated_at' => '2025-08-29 13:33:37',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 1,
            ),
            125 => 
            array (
                'id' => 198,
                'created_at' => '2025-08-29 13:34:30',
                'updated_at' => '2025-08-29 13:34:30',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 2,
            ),
            126 => 
            array (
                'id' => 199,
                'created_at' => '2025-08-29 13:34:44',
                'updated_at' => '2025-08-29 13:34:44',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 3,
            ),
            127 => 
            array (
                'id' => 200,
                'created_at' => '2025-08-29 13:34:57',
                'updated_at' => '2025-08-29 13:34:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 4,
            ),
            128 => 
            array (
                'id' => 201,
                'created_at' => '2025-08-29 13:36:12',
                'updated_at' => '2025-08-29 13:36:12',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 5,
            ),
            129 => 
            array (
                'id' => 202,
                'created_at' => '2025-08-29 13:38:33',
                'updated_at' => '2025-08-29 13:38:33',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 6,
            ),
            130 => 
            array (
                'id' => 203,
                'created_at' => '2025-08-29 13:39:12',
                'updated_at' => '2025-08-29 13:39:12',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 4,
            ),
            131 => 
            array (
                'id' => 204,
                'created_at' => '2025-08-29 13:42:28',
                'updated_at' => '2025-08-29 13:42:28',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 4,
            ),
            132 => 
            array (
                'id' => 205,
                'created_at' => '2025-08-29 14:03:19',
                'updated_at' => '2025-08-29 14:03:19',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Video',
                'lockable_id' => 1,
            ),
            133 => 
            array (
                'id' => 206,
                'created_at' => '2025-08-29 14:04:16',
                'updated_at' => '2025-08-29 14:04:16',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Video',
                'lockable_id' => 1,
            ),
            134 => 
            array (
                'id' => 207,
                'created_at' => '2025-08-29 14:05:10',
                'updated_at' => '2025-08-29 14:05:10',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Video',
                'lockable_id' => 2,
            ),
            135 => 
            array (
                'id' => 208,
                'created_at' => '2025-08-29 14:05:45',
                'updated_at' => '2025-08-29 14:05:45',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Video',
                'lockable_id' => 3,
            ),
            136 => 
            array (
                'id' => 211,
                'created_at' => '2025-08-29 14:26:57',
                'updated_at' => '2025-08-29 14:26:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 25,
            ),
            137 => 
            array (
                'id' => 213,
                'created_at' => '2025-09-03 10:02:08',
                'updated_at' => '2025-09-03 10:02:08',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 3,
            ),
            138 => 
            array (
                'id' => 215,
                'created_at' => '2025-09-03 10:05:29',
                'updated_at' => '2025-09-03 10:05:29',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 1,
            ),
            139 => 
            array (
                'id' => 216,
                'created_at' => '2025-09-03 10:08:01',
                'updated_at' => '2025-09-03 10:08:01',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 1,
            ),
            140 => 
            array (
                'id' => 218,
                'created_at' => '2025-09-03 10:10:14',
                'updated_at' => '2025-09-03 10:10:14',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 1,
            ),
            141 => 
            array (
                'id' => 219,
                'created_at' => '2025-09-03 10:11:04',
                'updated_at' => '2025-09-03 10:11:04',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 1,
            ),
            142 => 
            array (
                'id' => 220,
                'created_at' => '2025-09-03 10:11:24',
                'updated_at' => '2025-09-03 10:11:24',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 1,
            ),
            143 => 
            array (
                'id' => 223,
                'created_at' => '2025-09-03 11:17:39',
                'updated_at' => '2025-09-03 11:17:39',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            144 => 
            array (
                'id' => 224,
                'created_at' => '2025-09-03 11:23:00',
                'updated_at' => '2025-09-03 11:23:00',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            145 => 
            array (
                'id' => 226,
                'created_at' => '2025-09-03 11:24:18',
                'updated_at' => '2025-09-03 11:24:18',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            146 => 
            array (
                'id' => 227,
                'created_at' => '2025-09-03 11:24:29',
                'updated_at' => '2025-09-03 11:24:29',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            147 => 
            array (
                'id' => 228,
                'created_at' => '2025-09-03 11:25:31',
                'updated_at' => '2025-09-03 11:25:31',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            148 => 
            array (
                'id' => 229,
                'created_at' => '2025-09-03 12:06:35',
                'updated_at' => '2025-09-03 12:06:35',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            149 => 
            array (
                'id' => 230,
                'created_at' => '2025-09-03 12:13:09',
                'updated_at' => '2025-09-03 12:13:09',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 1,
            ),
            150 => 
            array (
                'id' => 231,
                'created_at' => '2025-09-03 12:15:16',
                'updated_at' => '2025-09-03 12:15:16',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 1,
            ),
            151 => 
            array (
                'id' => 232,
                'created_at' => '2025-09-03 13:21:23',
                'updated_at' => '2025-09-03 13:21:23',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Team',
                'lockable_id' => 1,
            ),
            152 => 
            array (
                'id' => 233,
                'created_at' => '2025-09-03 13:50:07',
                'updated_at' => '2025-09-03 13:50:07',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Team',
                'lockable_id' => 2,
            ),
            153 => 
            array (
                'id' => 234,
                'created_at' => '2025-09-03 13:51:00',
                'updated_at' => '2025-09-03 13:51:00',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Team',
                'lockable_id' => 3,
            ),
            154 => 
            array (
                'id' => 235,
                'created_at' => '2025-09-03 13:51:41',
                'updated_at' => '2025-09-03 13:51:41',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Team',
                'lockable_id' => 4,
            ),
            155 => 
            array (
                'id' => 236,
                'created_at' => '2025-09-03 13:51:57',
                'updated_at' => '2025-09-03 13:51:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Team',
                'lockable_id' => 5,
            ),
            156 => 
            array (
                'id' => 237,
                'created_at' => '2025-09-03 13:52:25',
                'updated_at' => '2025-09-03 13:52:25',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Team',
                'lockable_id' => 6,
            ),
            157 => 
            array (
                'id' => 238,
                'created_at' => '2025-09-03 13:52:49',
                'updated_at' => '2025-09-03 13:52:49',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Team',
                'lockable_id' => 7,
            ),
            158 => 
            array (
                'id' => 239,
                'created_at' => '2025-09-03 13:53:16',
                'updated_at' => '2025-09-03 13:53:16',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Team',
                'lockable_id' => 8,
            ),
            159 => 
            array (
                'id' => 240,
                'created_at' => '2025-09-03 13:59:11',
                'updated_at' => '2025-09-03 13:59:11',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 14,
            ),
            160 => 
            array (
                'id' => 242,
                'created_at' => '2025-09-03 14:06:34',
                'updated_at' => '2025-09-03 14:06:34',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 34,
            ),
            161 => 
            array (
                'id' => 243,
                'created_at' => '2025-09-03 14:52:44',
                'updated_at' => '2025-09-03 14:52:44',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 35,
            ),
            162 => 
            array (
                'id' => 244,
                'created_at' => '2025-09-03 15:35:58',
                'updated_at' => '2025-09-03 15:35:58',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Event',
                'lockable_id' => 1,
            ),
            163 => 
            array (
                'id' => 247,
                'created_at' => '2025-09-03 15:39:32',
                'updated_at' => '2025-09-03 15:39:32',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 36,
            ),
            164 => 
            array (
                'id' => 248,
                'created_at' => '2025-09-03 16:43:13',
                'updated_at' => '2025-09-03 16:43:13',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            165 => 
            array (
                'id' => 256,
                'created_at' => '2025-09-03 17:36:48',
                'updated_at' => '2025-09-03 17:36:48',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            166 => 
            array (
                'id' => 262,
                'created_at' => '2025-09-03 18:48:18',
                'updated_at' => '2025-09-03 18:48:18',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 37,
            ),
            167 => 
            array (
                'id' => 264,
                'created_at' => '2025-09-04 11:22:31',
                'updated_at' => '2025-09-04 11:22:31',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            168 => 
            array (
                'id' => 265,
                'created_at' => '2025-09-04 11:28:45',
                'updated_at' => '2025-09-04 11:28:45',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            169 => 
            array (
                'id' => 266,
                'created_at' => '2025-09-04 11:52:20',
                'updated_at' => '2025-09-04 11:52:20',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            170 => 
            array (
                'id' => 269,
                'created_at' => '2025-09-04 11:54:05',
                'updated_at' => '2025-09-04 11:54:05',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            171 => 
            array (
                'id' => 270,
                'created_at' => '2025-09-04 12:00:34',
                'updated_at' => '2025-09-04 12:00:34',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            172 => 
            array (
                'id' => 271,
                'created_at' => '2025-09-04 12:02:57',
                'updated_at' => '2025-09-04 12:02:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            173 => 
            array (
                'id' => 272,
                'created_at' => '2025-09-04 12:04:46',
                'updated_at' => '2025-09-04 12:04:46',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            174 => 
            array (
                'id' => 274,
                'created_at' => '2025-09-04 12:06:52',
                'updated_at' => '2025-09-04 12:06:52',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            175 => 
            array (
                'id' => 275,
                'created_at' => '2025-09-04 13:29:43',
                'updated_at' => '2025-09-04 13:29:43',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            176 => 
            array (
                'id' => 276,
                'created_at' => '2025-09-04 13:44:35',
                'updated_at' => '2025-09-04 13:44:35',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 2,
            ),
            177 => 
            array (
                'id' => 277,
                'created_at' => '2025-09-04 13:55:52',
                'updated_at' => '2025-09-04 13:55:52',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 10,
            ),
            178 => 
            array (
                'id' => 281,
                'created_at' => '2025-09-04 14:30:23',
                'updated_at' => '2025-09-04 14:30:23',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            179 => 
            array (
                'id' => 282,
                'created_at' => '2025-09-04 14:31:26',
                'updated_at' => '2025-09-04 14:31:26',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            180 => 
            array (
                'id' => 283,
                'created_at' => '2025-09-04 14:31:46',
                'updated_at' => '2025-09-04 14:31:46',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Team',
                'lockable_id' => 2,
            ),
            181 => 
            array (
                'id' => 284,
                'created_at' => '2025-09-04 14:34:33',
                'updated_at' => '2025-09-04 14:34:33',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            182 => 
            array (
                'id' => 286,
                'created_at' => '2025-09-04 14:49:44',
                'updated_at' => '2025-09-04 14:49:44',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            183 => 
            array (
                'id' => 291,
                'created_at' => '2025-09-04 14:56:40',
                'updated_at' => '2025-09-04 14:56:40',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            184 => 
            array (
                'id' => 293,
                'created_at' => '2025-09-04 14:57:23',
                'updated_at' => '2025-09-04 14:57:23',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            185 => 
            array (
                'id' => 295,
                'created_at' => '2025-09-05 08:40:39',
                'updated_at' => '2025-09-05 08:40:39',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 38,
            ),
            186 => 
            array (
                'id' => 296,
                'created_at' => '2025-09-05 09:45:35',
                'updated_at' => '2025-09-05 09:45:35',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            187 => 
            array (
                'id' => 297,
                'created_at' => '2025-09-05 09:46:11',
                'updated_at' => '2025-09-05 09:46:11',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            188 => 
            array (
                'id' => 299,
                'created_at' => '2025-09-05 09:46:55',
                'updated_at' => '2025-09-05 09:46:55',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            189 => 
            array (
                'id' => 300,
                'created_at' => '2025-09-05 09:47:42',
                'updated_at' => '2025-09-05 09:47:42',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            190 => 
            array (
                'id' => 301,
                'created_at' => '2025-09-05 09:47:57',
                'updated_at' => '2025-09-05 09:47:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            191 => 
            array (
                'id' => 302,
                'created_at' => '2025-09-05 09:53:47',
                'updated_at' => '2025-09-05 09:53:47',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            192 => 
            array (
                'id' => 303,
                'created_at' => '2025-09-05 09:54:56',
                'updated_at' => '2025-09-05 09:54:56',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            193 => 
            array (
                'id' => 304,
                'created_at' => '2025-09-05 09:55:26',
                'updated_at' => '2025-09-05 09:55:26',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            194 => 
            array (
                'id' => 305,
                'created_at' => '2025-09-05 09:55:40',
                'updated_at' => '2025-09-05 09:55:40',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            195 => 
            array (
                'id' => 307,
                'created_at' => '2025-09-05 09:56:05',
                'updated_at' => '2025-09-05 09:56:05',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            196 => 
            array (
                'id' => 308,
                'created_at' => '2025-09-05 09:56:15',
                'updated_at' => '2025-09-05 09:56:15',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            197 => 
            array (
                'id' => 310,
                'created_at' => '2025-09-05 09:57:01',
                'updated_at' => '2025-09-05 09:57:01',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            198 => 
            array (
                'id' => 311,
                'created_at' => '2025-09-05 10:00:51',
                'updated_at' => '2025-09-05 10:00:51',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            199 => 
            array (
                'id' => 312,
                'created_at' => '2025-09-05 10:01:36',
                'updated_at' => '2025-09-05 10:01:36',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            200 => 
            array (
                'id' => 314,
                'created_at' => '2025-09-05 10:02:07',
                'updated_at' => '2025-09-05 10:02:07',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            201 => 
            array (
                'id' => 317,
                'created_at' => '2025-09-05 10:02:48',
                'updated_at' => '2025-09-05 10:02:48',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            202 => 
            array (
                'id' => 319,
                'created_at' => '2025-09-05 10:03:06',
                'updated_at' => '2025-09-05 10:03:06',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            203 => 
            array (
                'id' => 320,
                'created_at' => '2025-09-05 10:04:40',
                'updated_at' => '2025-09-05 10:04:40',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            204 => 
            array (
                'id' => 321,
                'created_at' => '2025-09-05 10:05:07',
                'updated_at' => '2025-09-05 10:05:07',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            205 => 
            array (
                'id' => 322,
                'created_at' => '2025-09-05 10:07:11',
                'updated_at' => '2025-09-05 10:07:11',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            206 => 
            array (
                'id' => 323,
                'created_at' => '2025-09-05 10:12:29',
                'updated_at' => '2025-09-05 10:12:29',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            207 => 
            array (
                'id' => 325,
                'created_at' => '2025-09-05 10:13:33',
                'updated_at' => '2025-09-05 10:13:33',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            208 => 
            array (
                'id' => 326,
                'created_at' => '2025-09-05 10:14:46',
                'updated_at' => '2025-09-05 10:14:46',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            209 => 
            array (
                'id' => 327,
                'created_at' => '2025-09-05 10:15:45',
                'updated_at' => '2025-09-05 10:15:45',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            210 => 
            array (
                'id' => 328,
                'created_at' => '2025-09-05 10:16:00',
                'updated_at' => '2025-09-05 10:16:00',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            211 => 
            array (
                'id' => 330,
                'created_at' => '2025-09-05 10:16:21',
                'updated_at' => '2025-09-05 10:16:21',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            212 => 
            array (
                'id' => 333,
                'created_at' => '2025-09-05 10:16:41',
                'updated_at' => '2025-09-05 10:16:41',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            213 => 
            array (
                'id' => 334,
                'created_at' => '2025-09-05 10:17:55',
                'updated_at' => '2025-09-05 10:17:55',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            214 => 
            array (
                'id' => 335,
                'created_at' => '2025-09-05 10:25:15',
                'updated_at' => '2025-09-05 10:25:15',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            215 => 
            array (
                'id' => 339,
                'created_at' => '2025-09-05 10:25:51',
                'updated_at' => '2025-09-05 10:25:51',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            216 => 
            array (
                'id' => 340,
                'created_at' => '2025-09-05 10:28:26',
                'updated_at' => '2025-09-05 10:28:26',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            217 => 
            array (
                'id' => 341,
                'created_at' => '2025-09-05 10:29:08',
                'updated_at' => '2025-09-05 10:29:08',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            218 => 
            array (
                'id' => 342,
                'created_at' => '2025-09-05 10:57:07',
                'updated_at' => '2025-09-05 10:57:07',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            219 => 
            array (
                'id' => 343,
                'created_at' => '2025-09-05 11:00:19',
                'updated_at' => '2025-09-05 11:00:19',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            220 => 
            array (
                'id' => 344,
                'created_at' => '2025-09-05 11:00:47',
                'updated_at' => '2025-09-05 11:00:47',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            221 => 
            array (
                'id' => 345,
                'created_at' => '2025-09-05 11:01:57',
                'updated_at' => '2025-09-05 11:01:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            222 => 
            array (
                'id' => 347,
                'created_at' => '2025-09-05 11:02:28',
                'updated_at' => '2025-09-05 11:02:28',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            223 => 
            array (
                'id' => 348,
                'created_at' => '2025-09-05 11:03:15',
                'updated_at' => '2025-09-05 11:03:15',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            224 => 
            array (
                'id' => 349,
                'created_at' => '2025-09-05 11:04:44',
                'updated_at' => '2025-09-05 11:04:44',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            225 => 
            array (
                'id' => 350,
                'created_at' => '2025-09-05 11:09:19',
                'updated_at' => '2025-09-05 11:09:19',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            226 => 
            array (
                'id' => 352,
                'created_at' => '2025-09-05 11:17:15',
                'updated_at' => '2025-09-05 11:17:15',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            227 => 
            array (
                'id' => 353,
                'created_at' => '2025-09-05 11:18:17',
                'updated_at' => '2025-09-05 11:18:17',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            228 => 
            array (
                'id' => 354,
                'created_at' => '2025-09-05 11:26:42',
                'updated_at' => '2025-09-05 11:26:42',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            229 => 
            array (
                'id' => 355,
                'created_at' => '2025-09-05 11:29:36',
                'updated_at' => '2025-09-05 11:29:36',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            230 => 
            array (
                'id' => 358,
                'created_at' => '2025-09-05 11:31:30',
                'updated_at' => '2025-09-05 11:31:30',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            231 => 
            array (
                'id' => 359,
                'created_at' => '2025-09-05 11:38:06',
                'updated_at' => '2025-09-05 11:38:06',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            232 => 
            array (
                'id' => 360,
                'created_at' => '2025-09-05 11:40:50',
                'updated_at' => '2025-09-05 11:40:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            233 => 
            array (
                'id' => 362,
                'created_at' => '2025-09-05 11:46:31',
                'updated_at' => '2025-09-05 11:46:31',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            234 => 
            array (
                'id' => 364,
                'created_at' => '2025-09-05 11:56:03',
                'updated_at' => '2025-09-05 11:56:03',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            235 => 
            array (
                'id' => 365,
                'created_at' => '2025-09-05 12:00:27',
                'updated_at' => '2025-09-05 12:00:27',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            236 => 
            array (
                'id' => 366,
                'created_at' => '2025-09-05 12:01:32',
                'updated_at' => '2025-09-05 12:01:32',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            237 => 
            array (
                'id' => 367,
                'created_at' => '2025-09-05 12:02:36',
                'updated_at' => '2025-09-05 12:02:36',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            238 => 
            array (
                'id' => 368,
                'created_at' => '2025-09-05 12:02:48',
                'updated_at' => '2025-09-05 12:02:48',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            239 => 
            array (
                'id' => 369,
                'created_at' => '2025-09-05 12:05:34',
                'updated_at' => '2025-09-05 12:05:34',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            240 => 
            array (
                'id' => 370,
                'created_at' => '2025-09-05 12:08:33',
                'updated_at' => '2025-09-05 12:08:33',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            241 => 
            array (
                'id' => 371,
                'created_at' => '2025-09-05 12:20:58',
                'updated_at' => '2025-09-05 12:20:58',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            242 => 
            array (
                'id' => 372,
                'created_at' => '2025-09-05 12:25:50',
                'updated_at' => '2025-09-05 12:25:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            243 => 
            array (
                'id' => 373,
                'created_at' => '2025-09-05 12:42:30',
                'updated_at' => '2025-09-05 12:42:30',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            244 => 
            array (
                'id' => 374,
                'created_at' => '2025-09-05 12:45:12',
                'updated_at' => '2025-09-05 12:45:12',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            245 => 
            array (
                'id' => 375,
                'created_at' => '2025-09-05 12:53:52',
                'updated_at' => '2025-09-05 12:53:52',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            246 => 
            array (
                'id' => 376,
                'created_at' => '2025-09-05 12:54:31',
                'updated_at' => '2025-09-05 12:54:31',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            247 => 
            array (
                'id' => 378,
                'created_at' => '2025-09-05 12:55:31',
                'updated_at' => '2025-09-05 12:55:31',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            248 => 
            array (
                'id' => 379,
                'created_at' => '2025-09-05 18:12:45',
                'updated_at' => '2025-09-05 18:12:45',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            249 => 
            array (
                'id' => 380,
                'created_at' => '2025-09-06 15:28:06',
                'updated_at' => '2025-09-06 15:28:06',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Video',
                'lockable_id' => 1,
            ),
            250 => 
            array (
                'id' => 381,
                'created_at' => '2025-09-06 17:41:27',
                'updated_at' => '2025-09-06 17:41:27',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 40,
            ),
            251 => 
            array (
                'id' => 382,
                'created_at' => '2025-09-06 17:45:02',
                'updated_at' => '2025-09-06 17:45:02',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 41,
            ),
            252 => 
            array (
                'id' => 383,
                'created_at' => '2025-09-06 18:01:49',
                'updated_at' => '2025-09-06 18:01:49',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 14,
            ),
            253 => 
            array (
                'id' => 384,
                'created_at' => '2025-09-06 18:02:55',
                'updated_at' => '2025-09-06 18:02:55',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 37,
            ),
            254 => 
            array (
                'id' => 385,
                'created_at' => '2025-09-06 18:03:31',
                'updated_at' => '2025-09-06 18:03:31',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 40,
            ),
            255 => 
            array (
                'id' => 386,
                'created_at' => '2025-09-07 10:28:41',
                'updated_at' => '2025-09-07 10:28:41',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            256 => 
            array (
                'id' => 387,
                'created_at' => '2025-09-07 10:29:48',
                'updated_at' => '2025-09-07 10:29:48',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            257 => 
            array (
                'id' => 388,
                'created_at' => '2025-09-07 10:37:56',
                'updated_at' => '2025-09-07 10:37:56',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            258 => 
            array (
                'id' => 390,
                'created_at' => '2025-09-07 10:43:41',
                'updated_at' => '2025-09-07 10:43:41',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 25,
            ),
            259 => 
            array (
                'id' => 392,
                'created_at' => '2025-09-07 10:48:03',
                'updated_at' => '2025-09-07 10:48:03',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 5,
            ),
            260 => 
            array (
                'id' => 393,
                'created_at' => '2025-09-07 10:52:55',
                'updated_at' => '2025-09-07 10:52:55',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            261 => 
            array (
                'id' => 394,
                'created_at' => '2025-09-07 10:54:07',
                'updated_at' => '2025-09-07 10:54:07',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            262 => 
            array (
                'id' => 395,
                'created_at' => '2025-09-07 12:04:11',
                'updated_at' => '2025-09-07 12:04:11',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 11,
            ),
            263 => 
            array (
                'id' => 396,
                'created_at' => '2025-09-07 12:07:06',
                'updated_at' => '2025-09-07 12:07:06',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 9,
            ),
            264 => 
            array (
                'id' => 397,
                'created_at' => '2025-09-07 12:16:10',
                'updated_at' => '2025-09-07 12:16:10',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 9,
            ),
            265 => 
            array (
                'id' => 398,
                'created_at' => '2025-09-07 12:17:31',
                'updated_at' => '2025-09-07 12:17:31',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 9,
            ),
            266 => 
            array (
                'id' => 399,
                'created_at' => '2025-09-07 15:42:07',
                'updated_at' => '2025-09-07 15:42:07',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 1,
            ),
            267 => 
            array (
                'id' => 400,
                'created_at' => '2025-09-07 15:44:22',
                'updated_at' => '2025-09-07 15:44:22',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 14,
            ),
            268 => 
            array (
                'id' => 401,
                'created_at' => '2025-09-07 15:45:47',
                'updated_at' => '2025-09-07 15:45:47',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 1,
            ),
            269 => 
            array (
                'id' => 403,
                'created_at' => '2025-09-07 16:02:21',
                'updated_at' => '2025-09-07 16:02:21',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 12,
            ),
            270 => 
            array (
                'id' => 404,
                'created_at' => '2025-09-07 16:46:27',
                'updated_at' => '2025-09-07 16:46:27',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 12,
            ),
            271 => 
            array (
                'id' => 405,
                'created_at' => '2025-09-07 16:46:58',
                'updated_at' => '2025-09-07 16:46:58',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 2,
            ),
            272 => 
            array (
                'id' => 406,
                'created_at' => '2025-09-07 16:51:12',
                'updated_at' => '2025-09-07 16:51:12',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 13,
            ),
            273 => 
            array (
                'id' => 410,
                'created_at' => '2025-09-07 16:54:53',
                'updated_at' => '2025-09-07 16:54:53',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 13,
            ),
            274 => 
            array (
                'id' => 411,
                'created_at' => '2025-09-07 16:55:55',
                'updated_at' => '2025-09-07 16:55:55',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\LaraWidget',
                'lockable_id' => 12,
            ),
            275 => 
            array (
                'id' => 412,
                'created_at' => '2025-09-07 17:12:00',
                'updated_at' => '2025-09-07 17:12:00',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            276 => 
            array (
                'id' => 413,
                'created_at' => '2025-09-07 17:13:23',
                'updated_at' => '2025-09-07 17:13:23',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            277 => 
            array (
                'id' => 415,
                'created_at' => '2025-09-08 08:15:16',
                'updated_at' => '2025-09-08 08:15:16',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            278 => 
            array (
                'id' => 416,
                'created_at' => '2025-09-08 08:17:20',
                'updated_at' => '2025-09-08 08:17:20',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            279 => 
            array (
                'id' => 417,
                'created_at' => '2025-09-08 08:18:52',
                'updated_at' => '2025-09-08 08:18:52',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            280 => 
            array (
                'id' => 418,
                'created_at' => '2025-09-08 08:21:20',
                'updated_at' => '2025-09-08 08:21:20',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            281 => 
            array (
                'id' => 420,
                'created_at' => '2025-09-08 08:23:43',
                'updated_at' => '2025-09-08 08:23:43',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            282 => 
            array (
                'id' => 422,
                'created_at' => '2025-09-08 08:24:42',
                'updated_at' => '2025-09-08 08:24:42',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            283 => 
            array (
                'id' => 423,
                'created_at' => '2025-09-08 08:27:38',
                'updated_at' => '2025-09-08 08:27:38',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            284 => 
            array (
                'id' => 424,
                'created_at' => '2025-09-08 08:30:47',
                'updated_at' => '2025-09-08 08:30:47',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            285 => 
            array (
                'id' => 427,
                'created_at' => '2025-09-08 08:57:39',
                'updated_at' => '2025-09-08 08:57:39',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            286 => 
            array (
                'id' => 428,
                'created_at' => '2025-09-08 09:03:30',
                'updated_at' => '2025-09-08 09:03:30',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            287 => 
            array (
                'id' => 430,
                'created_at' => '2025-09-08 09:07:49',
                'updated_at' => '2025-09-08 09:07:49',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            288 => 
            array (
                'id' => 431,
                'created_at' => '2025-09-08 09:12:50',
                'updated_at' => '2025-09-08 09:12:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            289 => 
            array (
                'id' => 432,
                'created_at' => '2025-09-08 09:26:05',
                'updated_at' => '2025-09-08 09:26:05',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            290 => 
            array (
                'id' => 435,
                'created_at' => '2025-09-08 10:36:39',
                'updated_at' => '2025-09-08 10:36:39',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 5,
            ),
            291 => 
            array (
                'id' => 436,
                'created_at' => '2025-09-08 10:37:16',
                'updated_at' => '2025-09-08 10:37:16',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 5,
            ),
            292 => 
            array (
                'id' => 441,
                'created_at' => '2025-09-08 10:44:12',
                'updated_at' => '2025-09-08 10:44:12',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            293 => 
            array (
                'id' => 443,
                'created_at' => '2025-09-08 10:46:29',
                'updated_at' => '2025-09-08 10:46:29',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            294 => 
            array (
                'id' => 445,
                'created_at' => '2025-09-08 10:48:31',
                'updated_at' => '2025-09-08 10:48:31',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            295 => 
            array (
                'id' => 446,
                'created_at' => '2025-09-08 10:50:41',
                'updated_at' => '2025-09-08 10:50:41',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            296 => 
            array (
                'id' => 447,
                'created_at' => '2025-09-08 10:50:57',
                'updated_at' => '2025-09-08 10:50:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            297 => 
            array (
                'id' => 448,
                'created_at' => '2025-09-08 10:51:39',
                'updated_at' => '2025-09-08 10:51:39',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            298 => 
            array (
                'id' => 449,
                'created_at' => '2025-09-08 10:56:35',
                'updated_at' => '2025-09-08 10:56:35',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            299 => 
            array (
                'id' => 451,
                'created_at' => '2025-09-08 11:39:12',
                'updated_at' => '2025-09-08 11:39:12',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            300 => 
            array (
                'id' => 453,
                'created_at' => '2025-09-08 11:57:57',
                'updated_at' => '2025-09-08 11:57:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 5,
            ),
            301 => 
            array (
                'id' => 454,
                'created_at' => '2025-09-08 11:58:14',
                'updated_at' => '2025-09-08 11:58:14',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 5,
            ),
            302 => 
            array (
                'id' => 455,
                'created_at' => '2025-09-08 11:59:58',
                'updated_at' => '2025-09-08 11:59:58',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 5,
            ),
            303 => 
            array (
                'id' => 456,
                'created_at' => '2025-09-08 12:02:41',
                'updated_at' => '2025-09-08 12:02:41',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 5,
            ),
            304 => 
            array (
                'id' => 457,
                'created_at' => '2025-09-08 12:14:13',
                'updated_at' => '2025-09-08 12:14:13',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 25,
            ),
            305 => 
            array (
                'id' => 461,
                'created_at' => '2025-09-08 15:23:52',
                'updated_at' => '2025-09-08 15:23:52',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            306 => 
            array (
                'id' => 463,
                'created_at' => '2025-09-08 15:25:16',
                'updated_at' => '2025-09-08 15:25:16',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            307 => 
            array (
                'id' => 464,
                'created_at' => '2025-09-08 15:27:47',
                'updated_at' => '2025-09-08 15:27:47',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            308 => 
            array (
                'id' => 465,
                'created_at' => '2025-09-08 15:28:01',
                'updated_at' => '2025-09-08 15:28:01',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            309 => 
            array (
                'id' => 467,
                'created_at' => '2025-09-08 15:42:40',
                'updated_at' => '2025-09-08 15:42:40',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 25,
            ),
            310 => 
            array (
                'id' => 468,
                'created_at' => '2025-09-08 15:44:53',
                'updated_at' => '2025-09-08 15:44:53',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 42,
            ),
            311 => 
            array (
                'id' => 470,
                'created_at' => '2025-09-08 15:45:17',
                'updated_at' => '2025-09-08 15:45:17',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 42,
            ),
            312 => 
            array (
                'id' => 471,
                'created_at' => '2025-09-08 15:47:21',
                'updated_at' => '2025-09-08 15:47:21',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 42,
            ),
            313 => 
            array (
                'id' => 473,
                'created_at' => '2025-09-08 15:58:03',
                'updated_at' => '2025-09-08 15:58:03',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 42,
            ),
            314 => 
            array (
                'id' => 474,
                'created_at' => '2025-09-08 18:15:55',
                'updated_at' => '2025-09-08 18:15:55',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            315 => 
            array (
                'id' => 476,
                'created_at' => '2025-09-12 19:01:50',
                'updated_at' => '2025-09-12 19:01:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            316 => 
            array (
                'id' => 477,
                'created_at' => '2025-09-12 19:10:37',
                'updated_at' => '2025-09-12 19:10:37',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            317 => 
            array (
                'id' => 479,
                'created_at' => '2025-09-12 19:14:30',
                'updated_at' => '2025-09-12 19:14:30',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            318 => 
            array (
                'id' => 480,
                'created_at' => '2025-09-12 21:16:15',
                'updated_at' => '2025-09-12 21:16:15',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            319 => 
            array (
                'id' => 481,
                'created_at' => '2025-09-12 21:18:08',
                'updated_at' => '2025-09-12 21:18:08',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            320 => 
            array (
                'id' => 482,
                'created_at' => '2025-09-12 21:20:00',
                'updated_at' => '2025-09-12 21:20:00',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            321 => 
            array (
                'id' => 483,
                'created_at' => '2025-09-12 21:20:53',
                'updated_at' => '2025-09-12 21:20:53',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            322 => 
            array (
                'id' => 484,
                'created_at' => '2025-09-12 21:26:19',
                'updated_at' => '2025-09-12 21:26:19',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            323 => 
            array (
                'id' => 485,
                'created_at' => '2025-09-12 21:30:25',
                'updated_at' => '2025-09-12 21:30:25',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            324 => 
            array (
                'id' => 486,
                'created_at' => '2025-09-12 21:36:22',
                'updated_at' => '2025-09-12 21:36:22',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            325 => 
            array (
                'id' => 488,
                'created_at' => '2025-09-12 21:40:22',
                'updated_at' => '2025-09-12 21:40:22',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            326 => 
            array (
                'id' => 489,
                'created_at' => '2025-09-12 21:41:20',
                'updated_at' => '2025-09-12 21:41:20',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            327 => 
            array (
                'id' => 491,
                'created_at' => '2025-09-12 21:41:42',
                'updated_at' => '2025-09-12 21:41:42',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            328 => 
            array (
                'id' => 492,
                'created_at' => '2025-09-12 21:41:58',
                'updated_at' => '2025-09-12 21:41:58',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            329 => 
            array (
                'id' => 493,
                'created_at' => '2025-09-12 21:42:31',
                'updated_at' => '2025-09-12 21:42:31',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            330 => 
            array (
                'id' => 494,
                'created_at' => '2025-09-12 21:44:15',
                'updated_at' => '2025-09-12 21:44:15',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            331 => 
            array (
                'id' => 495,
                'created_at' => '2025-09-13 09:25:33',
                'updated_at' => '2025-09-13 09:25:33',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            332 => 
            array (
                'id' => 497,
                'created_at' => '2025-09-13 09:26:38',
                'updated_at' => '2025-09-13 09:26:38',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            333 => 
            array (
                'id' => 498,
                'created_at' => '2025-09-13 09:29:38',
                'updated_at' => '2025-09-13 09:29:38',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            334 => 
            array (
                'id' => 499,
                'created_at' => '2025-09-13 09:29:58',
                'updated_at' => '2025-09-13 09:29:58',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            335 => 
            array (
                'id' => 500,
                'created_at' => '2025-09-13 09:30:50',
                'updated_at' => '2025-09-13 09:30:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            336 => 
            array (
                'id' => 501,
                'created_at' => '2025-09-13 09:31:13',
                'updated_at' => '2025-09-13 09:31:13',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            337 => 
            array (
                'id' => 502,
                'created_at' => '2025-09-13 09:31:29',
                'updated_at' => '2025-09-13 09:31:29',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            338 => 
            array (
                'id' => 503,
                'created_at' => '2025-09-13 09:32:15',
                'updated_at' => '2025-09-13 09:32:15',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            339 => 
            array (
                'id' => 504,
                'created_at' => '2025-09-13 09:32:44',
                'updated_at' => '2025-09-13 09:32:44',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            340 => 
            array (
                'id' => 505,
                'created_at' => '2025-09-13 09:36:06',
                'updated_at' => '2025-09-13 09:36:06',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            341 => 
            array (
                'id' => 506,
                'created_at' => '2025-09-13 09:36:34',
                'updated_at' => '2025-09-13 09:36:34',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            342 => 
            array (
                'id' => 507,
                'created_at' => '2025-09-13 09:39:49',
                'updated_at' => '2025-09-13 09:39:49',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            343 => 
            array (
                'id' => 508,
                'created_at' => '2025-09-13 09:40:40',
                'updated_at' => '2025-09-13 09:40:40',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            344 => 
            array (
                'id' => 510,
                'created_at' => '2025-09-13 09:41:37',
                'updated_at' => '2025-09-13 09:41:37',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            345 => 
            array (
                'id' => 511,
                'created_at' => '2025-09-13 09:42:27',
                'updated_at' => '2025-09-13 09:42:27',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            346 => 
            array (
                'id' => 513,
                'created_at' => '2025-09-13 09:42:56',
                'updated_at' => '2025-09-13 09:42:56',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            347 => 
            array (
                'id' => 514,
                'created_at' => '2025-09-13 09:51:12',
                'updated_at' => '2025-09-13 09:51:12',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            348 => 
            array (
                'id' => 515,
                'created_at' => '2025-09-13 09:51:35',
                'updated_at' => '2025-09-13 09:51:35',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            349 => 
            array (
                'id' => 516,
                'created_at' => '2025-09-13 09:58:38',
                'updated_at' => '2025-09-13 09:58:38',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            350 => 
            array (
                'id' => 517,
                'created_at' => '2025-09-13 10:00:07',
                'updated_at' => '2025-09-13 10:00:07',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            351 => 
            array (
                'id' => 518,
                'created_at' => '2025-09-13 10:00:34',
                'updated_at' => '2025-09-13 10:00:34',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            352 => 
            array (
                'id' => 521,
                'created_at' => '2025-09-13 10:01:35',
                'updated_at' => '2025-09-13 10:01:35',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            353 => 
            array (
                'id' => 522,
                'created_at' => '2025-09-13 10:03:37',
                'updated_at' => '2025-09-13 10:03:37',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            354 => 
            array (
                'id' => 523,
                'created_at' => '2025-09-13 10:07:37',
                'updated_at' => '2025-09-13 10:07:37',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            355 => 
            array (
                'id' => 524,
                'created_at' => '2025-09-13 10:09:36',
                'updated_at' => '2025-09-13 10:09:36',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            356 => 
            array (
                'id' => 525,
                'created_at' => '2025-09-13 10:11:30',
                'updated_at' => '2025-09-13 10:11:30',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            357 => 
            array (
                'id' => 526,
                'created_at' => '2025-09-13 10:13:05',
                'updated_at' => '2025-09-13 10:13:05',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            358 => 
            array (
                'id' => 527,
                'created_at' => '2025-09-13 10:18:07',
                'updated_at' => '2025-09-13 10:18:07',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            359 => 
            array (
                'id' => 528,
                'created_at' => '2025-09-13 10:19:16',
                'updated_at' => '2025-09-13 10:19:16',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            360 => 
            array (
                'id' => 529,
                'created_at' => '2025-09-13 10:20:55',
                'updated_at' => '2025-09-13 10:20:55',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            361 => 
            array (
                'id' => 530,
                'created_at' => '2025-09-13 10:21:42',
                'updated_at' => '2025-09-13 10:21:42',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            362 => 
            array (
                'id' => 532,
                'created_at' => '2025-09-13 10:24:22',
                'updated_at' => '2025-09-13 10:24:22',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            363 => 
            array (
                'id' => 533,
                'created_at' => '2025-09-13 10:24:57',
                'updated_at' => '2025-09-13 10:24:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            364 => 
            array (
                'id' => 535,
                'created_at' => '2025-09-13 10:26:02',
                'updated_at' => '2025-09-13 10:26:02',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            365 => 
            array (
                'id' => 536,
                'created_at' => '2025-09-13 10:27:27',
                'updated_at' => '2025-09-13 10:27:27',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            366 => 
            array (
                'id' => 537,
                'created_at' => '2025-09-13 10:28:18',
                'updated_at' => '2025-09-13 10:28:18',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            367 => 
            array (
                'id' => 538,
                'created_at' => '2025-09-13 10:28:38',
                'updated_at' => '2025-09-13 10:28:38',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            368 => 
            array (
                'id' => 539,
                'created_at' => '2025-09-13 10:29:13',
                'updated_at' => '2025-09-13 10:29:13',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            369 => 
            array (
                'id' => 540,
                'created_at' => '2025-09-13 10:53:02',
                'updated_at' => '2025-09-13 10:53:02',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            370 => 
            array (
                'id' => 541,
                'created_at' => '2025-09-13 10:53:59',
                'updated_at' => '2025-09-13 10:53:59',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            371 => 
            array (
                'id' => 542,
                'created_at' => '2025-09-13 10:54:14',
                'updated_at' => '2025-09-13 10:54:14',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            372 => 
            array (
                'id' => 543,
                'created_at' => '2025-09-13 10:54:47',
                'updated_at' => '2025-09-13 10:54:47',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            373 => 
            array (
                'id' => 545,
                'created_at' => '2025-09-13 10:57:47',
                'updated_at' => '2025-09-13 10:57:47',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            374 => 
            array (
                'id' => 546,
                'created_at' => '2025-09-13 10:58:13',
                'updated_at' => '2025-09-13 10:58:13',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            375 => 
            array (
                'id' => 547,
                'created_at' => '2025-09-13 10:58:37',
                'updated_at' => '2025-09-13 10:58:37',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            376 => 
            array (
                'id' => 548,
                'created_at' => '2025-09-13 10:59:33',
                'updated_at' => '2025-09-13 10:59:33',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            377 => 
            array (
                'id' => 549,
                'created_at' => '2025-09-13 11:00:18',
                'updated_at' => '2025-09-13 11:00:18',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            378 => 
            array (
                'id' => 550,
                'created_at' => '2025-09-13 11:00:55',
                'updated_at' => '2025-09-13 11:00:55',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            379 => 
            array (
                'id' => 551,
                'created_at' => '2025-09-13 11:01:18',
                'updated_at' => '2025-09-13 11:01:18',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            380 => 
            array (
                'id' => 552,
                'created_at' => '2025-09-13 11:03:52',
                'updated_at' => '2025-09-13 11:03:52',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            381 => 
            array (
                'id' => 553,
                'created_at' => '2025-09-13 11:05:18',
                'updated_at' => '2025-09-13 11:05:18',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            382 => 
            array (
                'id' => 554,
                'created_at' => '2025-09-13 11:12:14',
                'updated_at' => '2025-09-13 11:12:14',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            383 => 
            array (
                'id' => 555,
                'created_at' => '2025-09-13 11:14:13',
                'updated_at' => '2025-09-13 11:14:13',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            384 => 
            array (
                'id' => 556,
                'created_at' => '2025-09-13 11:14:27',
                'updated_at' => '2025-09-13 11:14:27',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            385 => 
            array (
                'id' => 557,
                'created_at' => '2025-09-13 11:15:29',
                'updated_at' => '2025-09-13 11:15:29',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            386 => 
            array (
                'id' => 558,
                'created_at' => '2025-09-13 11:15:51',
                'updated_at' => '2025-09-13 11:15:51',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            387 => 
            array (
                'id' => 559,
                'created_at' => '2025-09-13 11:16:14',
                'updated_at' => '2025-09-13 11:16:14',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            388 => 
            array (
                'id' => 560,
                'created_at' => '2025-09-13 11:16:26',
                'updated_at' => '2025-09-13 11:16:26',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            389 => 
            array (
                'id' => 561,
                'created_at' => '2025-09-13 14:18:56',
                'updated_at' => '2025-09-13 14:18:56',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            390 => 
            array (
                'id' => 562,
                'created_at' => '2025-09-13 14:20:43',
                'updated_at' => '2025-09-13 14:20:43',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            391 => 
            array (
                'id' => 563,
                'created_at' => '2025-09-13 14:20:58',
                'updated_at' => '2025-09-13 14:20:58',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            392 => 
            array (
                'id' => 564,
                'created_at' => '2025-09-13 14:22:08',
                'updated_at' => '2025-09-13 14:22:08',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            393 => 
            array (
                'id' => 565,
                'created_at' => '2025-09-13 14:24:14',
                'updated_at' => '2025-09-13 14:24:14',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            394 => 
            array (
                'id' => 567,
                'created_at' => '2025-09-13 14:25:33',
                'updated_at' => '2025-09-13 14:25:33',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            395 => 
            array (
                'id' => 568,
                'created_at' => '2025-09-13 14:26:25',
                'updated_at' => '2025-09-13 14:26:25',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            396 => 
            array (
                'id' => 569,
                'created_at' => '2025-09-13 14:26:50',
                'updated_at' => '2025-09-13 14:26:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            397 => 
            array (
                'id' => 570,
                'created_at' => '2025-09-13 14:29:10',
                'updated_at' => '2025-09-13 14:29:10',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            398 => 
            array (
                'id' => 571,
                'created_at' => '2025-09-13 14:30:04',
                'updated_at' => '2025-09-13 14:30:04',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            399 => 
            array (
                'id' => 572,
                'created_at' => '2025-09-13 14:30:19',
                'updated_at' => '2025-09-13 14:30:19',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            400 => 
            array (
                'id' => 574,
                'created_at' => '2025-09-13 14:30:41',
                'updated_at' => '2025-09-13 14:30:41',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            401 => 
            array (
                'id' => 575,
                'created_at' => '2025-09-13 14:32:11',
                'updated_at' => '2025-09-13 14:32:11',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            402 => 
            array (
                'id' => 577,
                'created_at' => '2025-09-13 14:32:51',
                'updated_at' => '2025-09-13 14:32:51',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            403 => 
            array (
                'id' => 578,
                'created_at' => '2025-09-13 14:33:17',
                'updated_at' => '2025-09-13 14:33:17',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            404 => 
            array (
                'id' => 582,
                'created_at' => '2025-09-13 14:35:18',
                'updated_at' => '2025-09-13 14:35:18',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            405 => 
            array (
                'id' => 583,
                'created_at' => '2025-09-13 14:35:50',
                'updated_at' => '2025-09-13 14:35:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            406 => 
            array (
                'id' => 585,
                'created_at' => '2025-09-13 14:38:46',
                'updated_at' => '2025-09-13 14:38:46',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            407 => 
            array (
                'id' => 586,
                'created_at' => '2025-09-13 14:39:37',
                'updated_at' => '2025-09-13 14:39:37',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            408 => 
            array (
                'id' => 588,
                'created_at' => '2025-09-13 14:41:51',
                'updated_at' => '2025-09-13 14:41:51',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            409 => 
            array (
                'id' => 589,
                'created_at' => '2025-09-13 14:42:57',
                'updated_at' => '2025-09-13 14:42:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            410 => 
            array (
                'id' => 591,
                'created_at' => '2025-09-13 14:50:50',
                'updated_at' => '2025-09-13 14:50:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            411 => 
            array (
                'id' => 593,
                'created_at' => '2025-09-13 14:51:43',
                'updated_at' => '2025-09-13 14:51:43',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            412 => 
            array (
                'id' => 594,
                'created_at' => '2025-09-13 14:52:27',
                'updated_at' => '2025-09-13 14:52:27',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            413 => 
            array (
                'id' => 595,
                'created_at' => '2025-09-13 14:55:10',
                'updated_at' => '2025-09-13 14:55:10',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            414 => 
            array (
                'id' => 598,
                'created_at' => '2025-09-13 14:55:38',
                'updated_at' => '2025-09-13 14:55:38',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            415 => 
            array (
                'id' => 599,
                'created_at' => '2025-09-14 14:02:44',
                'updated_at' => '2025-09-14 14:02:44',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            416 => 
            array (
                'id' => 600,
                'created_at' => '2025-09-14 17:56:08',
                'updated_at' => '2025-09-14 17:56:08',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Team',
                'lockable_id' => 1,
            ),
            417 => 
            array (
                'id' => 601,
                'created_at' => '2025-09-14 18:07:30',
                'updated_at' => '2025-09-14 18:07:30',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Event',
                'lockable_id' => 2,
            ),
            418 => 
            array (
                'id' => 602,
                'created_at' => '2025-09-14 18:08:19',
                'updated_at' => '2025-09-14 18:08:19',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Event',
                'lockable_id' => 2,
            ),
            419 => 
            array (
                'id' => 603,
                'created_at' => '2025-09-14 18:14:33',
                'updated_at' => '2025-09-14 18:14:33',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Event',
                'lockable_id' => 2,
            ),
            420 => 
            array (
                'id' => 605,
                'created_at' => '2025-09-14 18:17:09',
                'updated_at' => '2025-09-14 18:17:09',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Event',
                'lockable_id' => 1,
            ),
            421 => 
            array (
                'id' => 606,
                'created_at' => '2025-09-15 07:11:58',
                'updated_at' => '2025-09-15 07:11:58',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            422 => 
            array (
                'id' => 607,
                'created_at' => '2025-09-15 09:25:32',
                'updated_at' => '2025-09-15 09:25:32',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            423 => 
            array (
                'id' => 608,
                'created_at' => '2025-09-15 09:26:11',
                'updated_at' => '2025-09-15 09:26:11',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            424 => 
            array (
                'id' => 609,
                'created_at' => '2025-09-15 09:27:06',
                'updated_at' => '2025-09-15 09:27:06',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            425 => 
            array (
                'id' => 612,
                'created_at' => '2025-09-15 09:35:23',
                'updated_at' => '2025-09-15 09:35:23',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            426 => 
            array (
                'id' => 613,
                'created_at' => '2025-09-15 09:38:51',
                'updated_at' => '2025-09-15 09:38:51',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            427 => 
            array (
                'id' => 614,
                'created_at' => '2025-09-15 09:39:25',
                'updated_at' => '2025-09-15 09:39:25',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            428 => 
            array (
                'id' => 615,
                'created_at' => '2025-09-15 09:39:55',
                'updated_at' => '2025-09-15 09:39:55',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            429 => 
            array (
                'id' => 619,
                'created_at' => '2025-09-15 09:42:13',
                'updated_at' => '2025-09-15 09:42:13',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            430 => 
            array (
                'id' => 621,
                'created_at' => '2025-09-15 09:52:29',
                'updated_at' => '2025-09-15 09:52:29',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            431 => 
            array (
                'id' => 625,
                'created_at' => '2025-09-15 09:54:14',
                'updated_at' => '2025-09-15 09:54:14',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            432 => 
            array (
                'id' => 626,
                'created_at' => '2025-09-15 09:54:50',
                'updated_at' => '2025-09-15 09:54:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            433 => 
            array (
                'id' => 627,
                'created_at' => '2025-09-15 09:55:40',
                'updated_at' => '2025-09-15 09:55:40',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            434 => 
            array (
                'id' => 629,
                'created_at' => '2025-09-15 09:58:45',
                'updated_at' => '2025-09-15 09:58:45',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            435 => 
            array (
                'id' => 630,
                'created_at' => '2025-09-15 10:00:59',
                'updated_at' => '2025-09-15 10:00:59',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            436 => 
            array (
                'id' => 636,
                'created_at' => '2025-09-15 10:09:11',
                'updated_at' => '2025-09-15 10:09:11',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            437 => 
            array (
                'id' => 638,
                'created_at' => '2025-09-15 10:16:55',
                'updated_at' => '2025-09-15 10:16:55',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            438 => 
            array (
                'id' => 639,
                'created_at' => '2025-09-15 10:18:13',
                'updated_at' => '2025-09-15 10:18:13',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            439 => 
            array (
                'id' => 640,
                'created_at' => '2025-09-15 10:22:51',
                'updated_at' => '2025-09-15 10:22:51',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            440 => 
            array (
                'id' => 641,
                'created_at' => '2025-09-15 10:40:52',
                'updated_at' => '2025-09-15 10:40:52',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            441 => 
            array (
                'id' => 642,
                'created_at' => '2025-09-15 10:42:07',
                'updated_at' => '2025-09-15 10:42:07',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            442 => 
            array (
                'id' => 643,
                'created_at' => '2025-09-15 10:43:07',
                'updated_at' => '2025-09-15 10:43:07',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            443 => 
            array (
                'id' => 648,
                'created_at' => '2025-09-15 10:43:51',
                'updated_at' => '2025-09-15 10:43:51',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            444 => 
            array (
                'id' => 654,
                'created_at' => '2025-09-16 17:35:19',
                'updated_at' => '2025-09-16 17:35:19',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Service',
                'lockable_id' => 1,
            ),
            445 => 
            array (
                'id' => 656,
                'created_at' => '2025-09-16 18:20:32',
                'updated_at' => '2025-09-16 18:20:32',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 5,
            ),
            446 => 
            array (
                'id' => 657,
                'created_at' => '2025-09-16 18:23:20',
                'updated_at' => '2025-09-16 18:23:20',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            447 => 
            array (
                'id' => 658,
                'created_at' => '2025-09-16 18:27:47',
                'updated_at' => '2025-09-16 18:27:47',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            448 => 
            array (
                'id' => 659,
                'created_at' => '2025-09-19 07:18:40',
                'updated_at' => '2025-09-19 07:18:40',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            449 => 
            array (
                'id' => 660,
                'created_at' => '2025-09-21 10:45:17',
                'updated_at' => '2025-09-21 10:45:17',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            450 => 
            array (
                'id' => 661,
                'created_at' => '2025-09-22 06:51:43',
                'updated_at' => '2025-09-22 06:51:43',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            451 => 
            array (
                'id' => 662,
                'created_at' => '2025-09-22 06:57:49',
                'updated_at' => '2025-09-22 06:57:49',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            452 => 
            array (
                'id' => 665,
                'created_at' => '2025-09-22 06:58:10',
                'updated_at' => '2025-09-22 06:58:10',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            453 => 
            array (
                'id' => 666,
                'created_at' => '2025-09-22 07:00:21',
                'updated_at' => '2025-09-22 07:00:21',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            454 => 
            array (
                'id' => 667,
                'created_at' => '2025-09-22 07:00:57',
                'updated_at' => '2025-09-22 07:00:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            455 => 
            array (
                'id' => 669,
                'created_at' => '2025-09-22 07:09:38',
                'updated_at' => '2025-09-22 07:09:38',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            456 => 
            array (
                'id' => 670,
                'created_at' => '2025-09-22 07:10:59',
                'updated_at' => '2025-09-22 07:10:59',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            457 => 
            array (
                'id' => 671,
                'created_at' => '2025-09-22 07:43:31',
                'updated_at' => '2025-09-22 07:43:31',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            458 => 
            array (
                'id' => 672,
                'created_at' => '2025-09-22 08:14:58',
                'updated_at' => '2025-09-22 08:14:58',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            459 => 
            array (
                'id' => 673,
                'created_at' => '2025-09-22 08:18:26',
                'updated_at' => '2025-09-22 08:18:26',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            460 => 
            array (
                'id' => 674,
                'created_at' => '2025-09-22 08:26:43',
                'updated_at' => '2025-09-22 08:26:43',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            461 => 
            array (
                'id' => 675,
                'created_at' => '2025-09-22 08:35:50',
                'updated_at' => '2025-09-22 08:35:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            462 => 
            array (
                'id' => 676,
                'created_at' => '2025-09-22 08:37:54',
                'updated_at' => '2025-09-22 08:37:54',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            463 => 
            array (
                'id' => 677,
                'created_at' => '2025-09-22 08:38:24',
                'updated_at' => '2025-09-22 08:38:24',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            464 => 
            array (
                'id' => 678,
                'created_at' => '2025-09-22 08:44:47',
                'updated_at' => '2025-09-22 08:44:47',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            465 => 
            array (
                'id' => 679,
                'created_at' => '2025-09-22 08:46:27',
                'updated_at' => '2025-09-22 08:46:27',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            466 => 
            array (
                'id' => 680,
                'created_at' => '2025-09-22 08:49:34',
                'updated_at' => '2025-09-22 08:49:34',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            467 => 
            array (
                'id' => 681,
                'created_at' => '2025-09-22 08:58:36',
                'updated_at' => '2025-09-22 08:58:36',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            468 => 
            array (
                'id' => 683,
                'created_at' => '2025-09-22 08:59:09',
                'updated_at' => '2025-09-22 08:59:09',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            469 => 
            array (
                'id' => 685,
                'created_at' => '2025-09-22 08:59:43',
                'updated_at' => '2025-09-22 08:59:43',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            470 => 
            array (
                'id' => 686,
                'created_at' => '2025-09-22 09:02:05',
                'updated_at' => '2025-09-22 09:02:05',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            471 => 
            array (
                'id' => 687,
                'created_at' => '2025-09-22 09:02:44',
                'updated_at' => '2025-09-22 09:02:44',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            472 => 
            array (
                'id' => 688,
                'created_at' => '2025-09-22 09:05:29',
                'updated_at' => '2025-09-22 09:05:29',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            473 => 
            array (
                'id' => 689,
                'created_at' => '2025-09-22 09:07:05',
                'updated_at' => '2025-09-22 09:07:05',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            474 => 
            array (
                'id' => 690,
                'created_at' => '2025-09-22 09:13:16',
                'updated_at' => '2025-09-22 09:13:16',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            475 => 
            array (
                'id' => 691,
                'created_at' => '2025-09-22 09:13:42',
                'updated_at' => '2025-09-22 09:13:42',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            476 => 
            array (
                'id' => 692,
                'created_at' => '2025-09-22 09:29:13',
                'updated_at' => '2025-09-22 09:29:13',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            477 => 
            array (
                'id' => 693,
                'created_at' => '2025-09-22 09:32:19',
                'updated_at' => '2025-09-22 09:32:19',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            478 => 
            array (
                'id' => 694,
                'created_at' => '2025-09-22 09:32:40',
                'updated_at' => '2025-09-22 09:32:40',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            479 => 
            array (
                'id' => 695,
                'created_at' => '2025-09-22 09:34:35',
                'updated_at' => '2025-09-22 09:34:35',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            480 => 
            array (
                'id' => 696,
                'created_at' => '2025-09-22 09:36:44',
                'updated_at' => '2025-09-22 09:36:44',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            481 => 
            array (
                'id' => 698,
                'created_at' => '2025-09-22 09:42:23',
                'updated_at' => '2025-09-22 09:42:23',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            482 => 
            array (
                'id' => 699,
                'created_at' => '2025-09-22 09:43:24',
                'updated_at' => '2025-09-22 09:43:24',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            483 => 
            array (
                'id' => 700,
                'created_at' => '2025-09-22 09:47:24',
                'updated_at' => '2025-09-22 09:47:24',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            484 => 
            array (
                'id' => 701,
                'created_at' => '2025-09-22 09:48:56',
                'updated_at' => '2025-09-22 09:48:56',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            485 => 
            array (
                'id' => 702,
                'created_at' => '2025-09-22 09:51:27',
                'updated_at' => '2025-09-22 09:51:27',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            486 => 
            array (
                'id' => 703,
                'created_at' => '2025-09-22 09:52:00',
                'updated_at' => '2025-09-22 09:52:00',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            487 => 
            array (
                'id' => 704,
                'created_at' => '2025-09-22 09:52:53',
                'updated_at' => '2025-09-22 09:52:53',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            488 => 
            array (
                'id' => 705,
                'created_at' => '2025-09-22 09:53:27',
                'updated_at' => '2025-09-22 09:53:27',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            489 => 
            array (
                'id' => 706,
                'created_at' => '2025-09-22 09:54:41',
                'updated_at' => '2025-09-22 09:54:41',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            490 => 
            array (
                'id' => 707,
                'created_at' => '2025-09-22 09:55:34',
                'updated_at' => '2025-09-22 09:55:34',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            491 => 
            array (
                'id' => 708,
                'created_at' => '2025-09-22 09:55:51',
                'updated_at' => '2025-09-22 09:55:51',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            492 => 
            array (
                'id' => 709,
                'created_at' => '2025-09-22 09:57:03',
                'updated_at' => '2025-09-22 09:57:03',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            493 => 
            array (
                'id' => 710,
                'created_at' => '2025-09-22 09:57:35',
                'updated_at' => '2025-09-22 09:57:35',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            494 => 
            array (
                'id' => 711,
                'created_at' => '2025-09-22 09:58:01',
                'updated_at' => '2025-09-22 09:58:01',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            495 => 
            array (
                'id' => 712,
                'created_at' => '2025-09-22 09:58:56',
                'updated_at' => '2025-09-22 09:58:56',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            496 => 
            array (
                'id' => 713,
                'created_at' => '2025-09-22 09:59:25',
                'updated_at' => '2025-09-22 09:59:25',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            497 => 
            array (
                'id' => 714,
                'created_at' => '2025-09-22 10:01:06',
                'updated_at' => '2025-09-22 10:01:06',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            498 => 
            array (
                'id' => 715,
                'created_at' => '2025-09-22 10:01:58',
                'updated_at' => '2025-09-22 10:01:58',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            499 => 
            array (
                'id' => 716,
                'created_at' => '2025-09-22 10:06:35',
                'updated_at' => '2025-09-22 10:06:35',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
        ));
        \DB::table('resource_locks')->insert(array (
            0 => 
            array (
                'id' => 717,
                'created_at' => '2025-09-22 10:08:33',
                'updated_at' => '2025-09-22 10:08:33',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            1 => 
            array (
                'id' => 718,
                'created_at' => '2025-09-22 10:08:50',
                'updated_at' => '2025-09-22 10:08:50',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            2 => 
            array (
                'id' => 719,
                'created_at' => '2025-09-22 10:09:41',
                'updated_at' => '2025-09-22 10:09:41',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            3 => 
            array (
                'id' => 720,
                'created_at' => '2025-09-22 10:10:09',
                'updated_at' => '2025-09-22 10:10:09',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            4 => 
            array (
                'id' => 721,
                'created_at' => '2025-09-22 11:40:45',
                'updated_at' => '2025-09-22 11:40:45',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            5 => 
            array (
                'id' => 722,
                'created_at' => '2025-09-22 11:42:57',
                'updated_at' => '2025-09-22 11:42:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            6 => 
            array (
                'id' => 723,
                'created_at' => '2025-09-22 11:43:26',
                'updated_at' => '2025-09-22 11:43:26',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            7 => 
            array (
                'id' => 724,
                'created_at' => '2025-09-22 11:46:31',
                'updated_at' => '2025-09-22 11:46:31',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            8 => 
            array (
                'id' => 725,
                'created_at' => '2025-09-22 11:46:44',
                'updated_at' => '2025-09-22 11:46:44',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            9 => 
            array (
                'id' => 726,
                'created_at' => '2025-09-22 11:50:37',
                'updated_at' => '2025-09-22 11:50:37',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            10 => 
            array (
                'id' => 727,
                'created_at' => '2025-09-22 12:05:03',
                'updated_at' => '2025-09-22 12:05:03',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            11 => 
            array (
                'id' => 728,
                'created_at' => '2025-09-22 12:05:29',
                'updated_at' => '2025-09-22 12:05:29',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            12 => 
            array (
                'id' => 729,
                'created_at' => '2025-09-22 12:06:05',
                'updated_at' => '2025-09-22 12:06:05',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            13 => 
            array (
                'id' => 731,
                'created_at' => '2025-09-22 12:15:36',
                'updated_at' => '2025-09-22 12:15:36',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            14 => 
            array (
                'id' => 732,
                'created_at' => '2025-09-22 12:19:27',
                'updated_at' => '2025-09-22 12:19:27',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            15 => 
            array (
                'id' => 733,
                'created_at' => '2025-09-22 12:21:20',
                'updated_at' => '2025-09-22 12:21:20',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            16 => 
            array (
                'id' => 734,
                'created_at' => '2025-09-22 13:27:21',
                'updated_at' => '2025-09-22 13:27:21',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            17 => 
            array (
                'id' => 735,
                'created_at' => '2025-09-22 13:28:27',
                'updated_at' => '2025-09-22 13:28:27',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            18 => 
            array (
                'id' => 736,
                'created_at' => '2025-09-22 13:29:06',
                'updated_at' => '2025-09-22 13:29:06',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            19 => 
            array (
                'id' => 737,
                'created_at' => '2025-09-22 13:30:16',
                'updated_at' => '2025-09-22 13:30:16',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            20 => 
            array (
                'id' => 738,
                'created_at' => '2025-09-22 13:32:39',
                'updated_at' => '2025-09-22 13:32:39',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            21 => 
            array (
                'id' => 739,
                'created_at' => '2025-09-22 13:33:42',
                'updated_at' => '2025-09-22 13:33:42',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            22 => 
            array (
                'id' => 741,
                'created_at' => '2025-09-22 13:34:56',
                'updated_at' => '2025-09-22 13:34:56',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            23 => 
            array (
                'id' => 742,
                'created_at' => '2025-09-22 13:35:41',
                'updated_at' => '2025-09-22 13:35:41',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            24 => 
            array (
                'id' => 743,
                'created_at' => '2025-09-22 13:35:56',
                'updated_at' => '2025-09-22 13:35:56',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            25 => 
            array (
                'id' => 745,
                'created_at' => '2025-09-22 13:40:39',
                'updated_at' => '2025-09-22 13:40:39',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            26 => 
            array (
                'id' => 748,
                'created_at' => '2025-09-22 13:41:59',
                'updated_at' => '2025-09-22 13:41:59',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
            27 => 
            array (
                'id' => 749,
                'created_at' => '2025-09-22 13:43:13',
                'updated_at' => '2025-09-22 13:43:13',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            28 => 
            array (
                'id' => 751,
                'created_at' => '2025-09-22 13:44:10',
                'updated_at' => '2025-09-22 13:44:10',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 30,
            ),
            29 => 
            array (
                'id' => 752,
                'created_at' => '2025-09-22 13:44:23',
                'updated_at' => '2025-09-22 13:44:23',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 22,
            ),
            30 => 
            array (
                'id' => 754,
                'created_at' => '2025-09-22 13:46:15',
                'updated_at' => '2025-09-22 13:46:15',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 22,
            ),
            31 => 
            array (
                'id' => 756,
                'created_at' => '2025-09-22 13:46:57',
                'updated_at' => '2025-09-22 13:46:57',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 22,
            ),
            32 => 
            array (
                'id' => 757,
                'created_at' => '2025-09-22 13:47:17',
                'updated_at' => '2025-09-22 13:47:17',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 22,
            ),
            33 => 
            array (
                'id' => 758,
                'created_at' => '2025-09-22 13:47:30',
                'updated_at' => '2025-09-22 13:47:30',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 22,
            ),
            34 => 
            array (
                'id' => 760,
                'created_at' => '2025-09-22 13:48:05',
                'updated_at' => '2025-09-22 13:48:05',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 22,
            ),
            35 => 
            array (
                'id' => 769,
                'created_at' => '2025-09-22 13:57:40',
                'updated_at' => '2025-09-22 13:57:40',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 5,
            ),
            36 => 
            array (
                'id' => 770,
                'created_at' => '2025-09-22 14:08:30',
                'updated_at' => '2025-09-22 14:08:30',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Doc',
                'lockable_id' => 5,
            ),
            37 => 
            array (
                'id' => 771,
                'created_at' => '2025-09-22 14:09:21',
                'updated_at' => '2025-09-22 14:09:21',
                'user_id' => 3,
                'lockable_type' => 'Lara\\App\\Models\\Blog',
                'lockable_id' => 31,
            ),
            38 => 
            array (
                'id' => 773,
                'created_at' => '2025-09-22 18:09:26',
                'updated_at' => '2025-09-22 18:09:26',
                'user_id' => 3,
                'lockable_type' => 'Lara\\Common\\Models\\Page',
                'lockable_id' => 2,
            ),
        ));
        
        
    }
}