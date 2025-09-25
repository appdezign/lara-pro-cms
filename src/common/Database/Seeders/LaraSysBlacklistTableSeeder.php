<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraSysBlacklistTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_sys_blacklist')->delete();
        
        
        
    }
}