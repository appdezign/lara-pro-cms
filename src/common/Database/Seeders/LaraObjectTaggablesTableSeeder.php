<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraObjectTaggablesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_object_taggables')->delete();
        
        \DB::table('lara_object_taggables')->insert(array (
            0 => 
            array (
                'id' => 247,
                'tag_id' => 2060,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 3,
            ),
            1 => 
            array (
                'id' => 248,
                'tag_id' => 2059,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 3,
            ),
            2 => 
            array (
                'id' => 249,
                'tag_id' => 2060,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 22,
            ),
            3 => 
            array (
                'id' => 250,
                'tag_id' => 2059,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 22,
            ),
            4 => 
            array (
                'id' => 251,
                'tag_id' => 2060,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 23,
            ),
            5 => 
            array (
                'id' => 252,
                'tag_id' => 2063,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 23,
            ),
            6 => 
            array (
                'id' => 253,
                'tag_id' => 2060,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 24,
            ),
            7 => 
            array (
                'id' => 254,
                'tag_id' => 2061,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 24,
            ),
            8 => 
            array (
                'id' => 255,
                'tag_id' => 2060,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 25,
            ),
            9 => 
            array (
                'id' => 256,
                'tag_id' => 2059,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 25,
            ),
            10 => 
            array (
                'id' => 257,
                'tag_id' => 2062,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 26,
            ),
            11 => 
            array (
                'id' => 258,
                'tag_id' => 2066,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 26,
            ),
            12 => 
            array (
                'id' => 259,
                'tag_id' => 2062,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 27,
            ),
            13 => 
            array (
                'id' => 260,
                'tag_id' => 2062,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 29,
            ),
            14 => 
            array (
                'id' => 261,
                'tag_id' => 2066,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 29,
            ),
            15 => 
            array (
                'id' => 262,
                'tag_id' => 2062,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 30,
            ),
            16 => 
            array (
                'id' => 263,
                'tag_id' => 2065,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 30,
            ),
            17 => 
            array (
                'id' => 265,
                'tag_id' => 2064,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 31,
            ),
            18 => 
            array (
                'id' => 266,
                'tag_id' => 2073,
                'entity_type' => 'Lara\\Common\\Models\\Slider',
                'entity_id' => 3,
            ),
            19 => 
            array (
                'id' => 267,
                'tag_id' => 2073,
                'entity_type' => 'Lara\\Common\\Models\\Slider',
                'entity_id' => 2,
            ),
            20 => 
            array (
                'id' => 268,
                'tag_id' => 2073,
                'entity_type' => 'Lara\\Common\\Models\\Slider',
                'entity_id' => 4,
            ),
            21 => 
            array (
                'id' => 269,
                'tag_id' => 2077,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 1,
            ),
            22 => 
            array (
                'id' => 270,
                'tag_id' => 2077,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 2,
            ),
            23 => 
            array (
                'id' => 271,
                'tag_id' => 2078,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 3,
            ),
            24 => 
            array (
                'id' => 272,
                'tag_id' => 2080,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 4,
            ),
            25 => 
            array (
                'id' => 273,
                'tag_id' => 2078,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 5,
            ),
            26 => 
            array (
                'id' => 274,
                'tag_id' => 2079,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 7,
            ),
            27 => 
            array (
                'id' => 275,
                'tag_id' => 2081,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 8,
            ),
            28 => 
            array (
                'id' => 276,
                'tag_id' => 2078,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 6,
            ),
            29 => 
            array (
                'id' => 277,
                'tag_id' => 2082,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 6,
            ),
            30 => 
            array (
                'id' => 278,
                'tag_id' => 2067,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 27,
            ),
            31 => 
            array (
                'id' => 279,
                'tag_id' => 2083,
                'entity_type' => 'Lara\\App\\Models\\Event',
                'entity_id' => 1,
            ),
            32 => 
            array (
                'id' => 280,
                'tag_id' => 2083,
                'entity_type' => 'Lara\\App\\Models\\Event',
                'entity_id' => 2,
            ),
            33 => 
            array (
                'id' => 281,
                'tag_id' => 2088,
                'entity_type' => 'Lara\\App\\Models\\Service',
                'entity_id' => 1,
            ),
            34 => 
            array (
                'id' => 282,
                'tag_id' => 2091,
                'entity_type' => 'Lara\\App\\Models\\Service',
                'entity_id' => 1,
            ),
            35 => 
            array (
                'id' => 283,
                'tag_id' => 2089,
                'entity_type' => 'Lara\\App\\Models\\Service',
                'entity_id' => 2,
            ),
            36 => 
            array (
                'id' => 284,
                'tag_id' => 2092,
                'entity_type' => 'Lara\\App\\Models\\Service',
                'entity_id' => 2,
            ),
            37 => 
            array (
                'id' => 285,
                'tag_id' => 2090,
                'entity_type' => 'Lara\\App\\Models\\Service',
                'entity_id' => 3,
            ),
            38 => 
            array (
                'id' => 286,
                'tag_id' => 2093,
                'entity_type' => 'Lara\\App\\Models\\Service',
                'entity_id' => 3,
            ),
            39 => 
            array (
                'id' => 287,
                'tag_id' => 2095,
                'entity_type' => 'Lara\\App\\Models\\Testimonial',
                'entity_id' => 2,
            ),
            40 => 
            array (
                'id' => 288,
                'tag_id' => 2095,
                'entity_type' => 'Lara\\App\\Models\\Testimonial',
                'entity_id' => 1,
            ),
            41 => 
            array (
                'id' => 289,
                'tag_id' => 2095,
                'entity_type' => 'Lara\\App\\Models\\Testimonial',
                'entity_id' => 3,
            ),
            42 => 
            array (
                'id' => 290,
                'tag_id' => 2096,
                'entity_type' => 'Lara\\App\\Models\\Testimonial',
                'entity_id' => 4,
            ),
            43 => 
            array (
                'id' => 291,
                'tag_id' => 2096,
                'entity_type' => 'Lara\\App\\Models\\Testimonial',
                'entity_id' => 5,
            ),
            44 => 
            array (
                'id' => 292,
                'tag_id' => 2096,
                'entity_type' => 'Lara\\App\\Models\\Testimonial',
                'entity_id' => 6,
            ),
            45 => 
            array (
                'id' => 293,
                'tag_id' => 2097,
                'entity_type' => 'Lara\\App\\Models\\Portfolio',
                'entity_id' => 1,
            ),
            46 => 
            array (
                'id' => 294,
                'tag_id' => 2097,
                'entity_type' => 'Lara\\App\\Models\\Portfolio',
                'entity_id' => 2,
            ),
            47 => 
            array (
                'id' => 295,
                'tag_id' => 2097,
                'entity_type' => 'Lara\\App\\Models\\Portfolio',
                'entity_id' => 3,
            ),
            48 => 
            array (
                'id' => 296,
                'tag_id' => 2101,
                'entity_type' => 'Lara\\App\\Models\\Portfolio',
                'entity_id' => 4,
            ),
            49 => 
            array (
                'id' => 297,
                'tag_id' => 2101,
                'entity_type' => 'Lara\\App\\Models\\Portfolio',
                'entity_id' => 5,
            ),
            50 => 
            array (
                'id' => 298,
                'tag_id' => 2098,
                'entity_type' => 'Lara\\App\\Models\\Portfolio',
                'entity_id' => 6,
            ),
            51 => 
            array (
                'id' => 299,
                'tag_id' => 2098,
                'entity_type' => 'Lara\\App\\Models\\Portfolio',
                'entity_id' => 7,
            ),
            52 => 
            array (
                'id' => 300,
                'tag_id' => 2076,
                'entity_type' => 'Lara\\Common\\Models\\Slider',
                'entity_id' => 5,
            ),
            53 => 
            array (
                'id' => 301,
                'tag_id' => 2076,
                'entity_type' => 'Lara\\Common\\Models\\Slider',
                'entity_id' => 6,
            ),
            54 => 
            array (
                'id' => 302,
                'tag_id' => 2102,
                'entity_type' => 'Lara\\App\\Models\\Gallery',
                'entity_id' => 1,
            ),
            55 => 
            array (
                'id' => 303,
                'tag_id' => 2103,
                'entity_type' => 'Lara\\App\\Models\\Gallery',
                'entity_id' => 2,
            ),
            56 => 
            array (
                'id' => 304,
                'tag_id' => 2106,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 1,
            ),
            57 => 
            array (
                'id' => 305,
                'tag_id' => 2106,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 2,
            ),
            58 => 
            array (
                'id' => 306,
                'tag_id' => 2108,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 2,
            ),
            59 => 
            array (
                'id' => 307,
                'tag_id' => 2107,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 3,
            ),
            60 => 
            array (
                'id' => 308,
                'tag_id' => 2106,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 4,
            ),
            61 => 
            array (
                'id' => 309,
                'tag_id' => 2106,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 5,
            ),
            62 => 
            array (
                'id' => 310,
                'tag_id' => 2108,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 5,
            ),
            63 => 
            array (
                'id' => 311,
                'tag_id' => 2106,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 6,
            ),
            64 => 
            array (
                'id' => 312,
                'tag_id' => 2109,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 6,
            ),
        ));
        
        
    }
}