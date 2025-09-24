<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BreezySessionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('breezy_sessions')->delete();
        
        
        
    }
}