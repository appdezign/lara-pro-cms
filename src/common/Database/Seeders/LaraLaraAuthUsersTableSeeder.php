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

        \DB::table('lara_auth_users')->insert([
            0 => [
                'id' => 3,
                'name' => 'superadmin',
                'email' => 's.hoeksma@firmaq.nl',
                'email_verified_at' => null,
                'firstname' => 'Super',
                'middlename' => 'Admin',
                'lastname' => 'Firmaq',
                'displayname' => null,
                'biography' => null,
                'locale' => 'nl',
                'password' => '$2y$12$M5VlPPZUdbxUdmoLm2KPcuigoZ1PppkPJ8kNyAORXWN4q41BVPWAu',
                'remember_token' => null,
                'api_token' => '',
                'created_at' => '2025-06-18 09:07:53',
                'deleted_at' => null,
                'updated_at' => '2026-01-25 19:34:57',
                'last_renew_password_at' => null,
                'force_renew_password' => 0,
                'locked_at' => null,
                'locked_by' => null,
            ],
        ]);

    }
}
