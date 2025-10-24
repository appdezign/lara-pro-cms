<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraObjectFilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_object_files')->delete();
        
        \DB::table('lara_object_files')->insert(array (
            0 => 
            array (
                'id' => 81,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 22,
                'entity_files' => '[]',
            ),
            1 => 
            array (
                'id' => 82,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 1,
                'entity_files' => '[{"doc_date": "2025-10-20 09:37", "doc_filename": "teams/20251020093815-test.pdf", "doc_original": "Test.pdf"}]',
            ),
            2 => 
            array (
                'id' => 83,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 2,
                'entity_files' => '[]',
            ),
            3 => 
            array (
                'id' => 84,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 2,
                'entity_files' => '[{"doc_date": "2025-09-13 14:39", "doc_filename": "pages/20250913143954-test.pdf", "doc_original": "Test.pdf"}]',
            ),
            4 => 
            array (
                'id' => 85,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 23,
                'entity_files' => '[]',
            ),
            5 => 
            array (
                'id' => 86,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 3,
                'entity_files' => '[]',
            ),
            6 => 
            array (
                'id' => 87,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 4,
                'entity_files' => '[]',
            ),
            7 => 
            array (
                'id' => 88,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 5,
                'entity_files' => '[]',
            ),
            8 => 
            array (
                'id' => 89,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 6,
                'entity_files' => '[]',
            ),
            9 => 
            array (
                'id' => 90,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 7,
                'entity_files' => '[]',
            ),
            10 => 
            array (
                'id' => 91,
                'entity_type' => 'Lara\\App\\Models\\Team',
                'entity_id' => 8,
                'entity_files' => '[]',
            ),
            11 => 
            array (
                'id' => 92,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 27,
                'entity_files' => '[]',
            ),
            12 => 
            array (
                'id' => 93,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 31,
                'entity_files' => '[{"doc_date": "2025-08-25 12:09", "doc_filename": "blogs/20250825120923-test.pdf", "doc_original": "Test.pdf"}]',
            ),
            13 => 
            array (
                'id' => 94,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 17,
                'entity_files' => '[]',
            ),
            14 => 
            array (
                'id' => 95,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 19,
                'entity_files' => '[]',
            ),
            15 => 
            array (
                'id' => 96,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 30,
                'entity_files' => '[]',
            ),
            16 => 
            array (
                'id' => 97,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 5,
                'entity_files' => '[]',
            ),
            17 => 
            array (
                'id' => 98,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 29,
                'entity_files' => '[]',
            ),
            18 => 
            array (
                'id' => 99,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 26,
                'entity_files' => '[]',
            ),
            19 => 
            array (
                'id' => 100,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 25,
                'entity_files' => '[]',
            ),
            20 => 
            array (
                'id' => 101,
                'entity_type' => 'Lara\\App\\Models\\Blog',
                'entity_id' => 24,
                'entity_files' => '[]',
            ),
            21 => 
            array (
                'id' => 102,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 1,
                'entity_files' => '[{"doc_date": "2025-08-29 13:33", "doc_filename": "docs/20250829133425-doc-test.pdf", "doc_original": "doc-test.pdf"}]',
            ),
            22 => 
            array (
                'id' => 103,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 2,
                'entity_files' => '[{"doc_date": "2025-08-29 13:34", "doc_filename": "docs/20250829133438-doc-test.pdf", "doc_original": "doc-test.pdf"}]',
            ),
            23 => 
            array (
                'id' => 104,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 3,
                'entity_files' => '[{"doc_date": "2025-08-29 13:34", "doc_filename": "docs/20250829133452-doc-test.pdf", "doc_original": "doc-test.pdf"}]',
            ),
            24 => 
            array (
                'id' => 105,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 4,
                'entity_files' => '[{"doc_date": "2025-08-29 13:39", "doc_filename": "docs/20250829133931-doc-test.pdf", "doc_original": "doc-test.pdf"}]',
            ),
            25 => 
            array (
                'id' => 106,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 5,
                'entity_files' => '[]',
            ),
            26 => 
            array (
                'id' => 107,
                'entity_type' => 'Lara\\App\\Models\\Doc',
                'entity_id' => 6,
                'entity_files' => '[{"doc_date": "2025-08-29 13:38", "doc_filename": "docs/20250829133842-doc-test.pdf", "doc_original": "doc-test.pdf"}]',
            ),
            27 => 
            array (
                'id' => 108,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 25,
                'entity_files' => '[]',
            ),
            28 => 
            array (
                'id' => 109,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 14,
                'entity_files' => '[]',
            ),
            29 => 
            array (
                'id' => 110,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 34,
                'entity_files' => '[]',
            ),
            30 => 
            array (
                'id' => 111,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 35,
                'entity_files' => '[]',
            ),
            31 => 
            array (
                'id' => 112,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 36,
                'entity_files' => '[]',
            ),
            32 => 
            array (
                'id' => 113,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 37,
                'entity_files' => '[]',
            ),
            33 => 
            array (
                'id' => 114,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 38,
                'entity_files' => '[]',
            ),
            34 => 
            array (
                'id' => 115,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 40,
                'entity_files' => '[]',
            ),
            35 => 
            array (
                'id' => 116,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 41,
                'entity_files' => '[]',
            ),
            36 => 
            array (
                'id' => 117,
                'entity_type' => 'Lara\\Common\\Models\\Page',
                'entity_id' => 42,
                'entity_files' => '[]',
            ),
            37 => 
            array (
                'id' => 118,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 1,
                'entity_files' => '[]',
            ),
            38 => 
            array (
                'id' => 119,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 2,
                'entity_files' => '[]',
            ),
            39 => 
            array (
                'id' => 120,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 3,
                'entity_files' => '[]',
            ),
            40 => 
            array (
                'id' => 121,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 5,
                'entity_files' => '[]',
            ),
            41 => 
            array (
                'id' => 122,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 9,
                'entity_files' => '[]',
            ),
            42 => 
            array (
                'id' => 123,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 10,
                'entity_files' => '[]',
            ),
            43 => 
            array (
                'id' => 124,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 11,
                'entity_files' => '[]',
            ),
            44 => 
            array (
                'id' => 125,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 12,
                'entity_files' => '[]',
            ),
            45 => 
            array (
                'id' => 126,
                'entity_type' => 'Lara\\App\\Models\\Product',
                'entity_id' => 14,
                'entity_files' => '[]',
            ),
            46 => 
            array (
                'id' => 127,
                'entity_type' => 'Lara\\App\\Models\\City',
                'entity_id' => 1,
                'entity_files' => '[]',
            ),
        ));
        
        
    }
}