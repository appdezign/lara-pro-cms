<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LaraAuthUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lara_auth_users')->delete();
        
        \DB::table('lara_auth_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'email' => 'beheer@firmaq.nl',
                'email_verified_at' => '2025-06-17 20:54:55',
                'locale' => 'en',
                'password' => '$2y$12$wjz6b6gqGA.ZeG9YwH7XaekPrsQLlSVgxRwGnKyC9HmjRgQJZdPXK',
                'remember_token' => NULL,
                'created_at' => '2025-06-11 18:09:31',
                'deleted_at' => NULL,
                'updated_at' => '2025-06-11 18:09:31',
                'last_renew_password_at' => NULL,
                'force_renew_password' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'webmaster',
                'email' => 'sh@firmaq.nl',
                'email_verified_at' => '2025-06-17 20:54:55',
                'locale' => 'nl',
                'password' => '$2y$12$wLixVTfVgmmLiiZnPIPu7uyXZbTexxWDlyvttenz3txHEuodBofv6',
                'remember_token' => NULL,
                'created_at' => '2025-06-17 18:52:38',
                'deleted_at' => NULL,
                'updated_at' => '2025-06-17 18:52:38',
                'last_renew_password_at' => NULL,
                'force_renew_password' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'superadmin',
                'email' => 's.hoeksma@firmaq.nl',
                'email_verified_at' => NULL,
                'locale' => 'nl',
                'password' => '$2y$12$M5VlPPZUdbxUdmoLm2KPcuigoZ1PppkPJ8kNyAORXWN4q41BVPWAu',
                'remember_token' => NULL,
                'created_at' => '2025-06-18 09:07:53',
                'deleted_at' => NULL,
                'updated_at' => '2025-06-18 09:07:53',
                'last_renew_password_at' => NULL,
                'force_renew_password' => 0,
            ),
        ));
        
        
    }
}