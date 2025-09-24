<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LaraAuthPasswordResetTokensTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_auth_password_reset_tokens')->delete();
        
        
        
    }
}