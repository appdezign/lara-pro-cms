<?php

namespace Lara\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class LaraLaraAuthUsersTableSeeder extends Seeder
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
                'id' => 3,
                'name' => 'superadmin',
                'email' => 's.hoeksma@firmaq.nl',
                'email_verified_at' => NULL,
                'firstname' => 'Super',
                'middlename' => 'Admin',
                'lastname' => 'Firmaq',
                'displayname' => NULL,
                'biography' => NULL,
                'locale' => 'nl',
                'password' => '$2y$12$M5VlPPZUdbxUdmoLm2KPcuigoZ1PppkPJ8kNyAORXWN4q41BVPWAu',
                'remember_token' => NULL,
                'api_token' => '',
                'created_at' => '2025-06-18 09:07:53',
                'deleted_at' => NULL,
                'updated_at' => '2026-01-25 19:34:57',
                'last_renew_password_at' => NULL,
                'force_renew_password' => 0,
                'locked_at' => NULL,
                'locked_by' => NULL,
            ),
        ));
        
        
    }
}