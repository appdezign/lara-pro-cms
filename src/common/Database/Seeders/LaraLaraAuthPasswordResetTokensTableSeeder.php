<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraLaraAuthPasswordResetTokensTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_auth_password_reset_tokens')->delete();
        
        \DB::table('lara_auth_password_reset_tokens')->insert(array (
            0 => 
            array (
                'email' => 'beheer@firmaq.nl',
                'token' => '$2y$12$lQza/aiLlzBWug929endcuKWJRKYDvQqy77scEI5fDfFm2iCd/Nym',
                'created_at' => '2026-03-17 13:02:47',
            ),
        ));
        
        
    }
}