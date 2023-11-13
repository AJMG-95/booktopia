<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {


        $users = [
            [
                'id' => 1,
                'nickname' => 'admin',
                'name' => 'admin',
                'surnames' => 'admin',
                'password' => Hash::make('admin'),
                'birth_date' => '1995-09-27',
                'country_id' => 1, // Adjust the country ID as needed
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'rol_id' => 1, // Adjust the role ID as needed
                'blocked' => false,
                'strikes' => 0,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'nickname' => 'subadmin',
                'name' => 'subadmin',
                'surnames' => 'subadmin',
                'password' => Hash::make('subadmin'),
                'birth_date' => '1995-09-27',
                'country_id' => 1, // Ajusta el ID del país según sea necesario
                'email' => 'subadmin@subadmin.com',
                'email_verified_at' => now(),
                'rol_id' => 2, // Ajusta el ID del rol según sea necesario
                'blocked' => false,
                'strikes' => 0,
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'nickname' => 'pepe',
                'name' => 'pepe',
                'surnames' => 'pepe',
                'password' => Hash::make('pepe'),
                'birth_date' => '1995-09-27',
                'country_id' => 1, // Adjust the country ID as needed
                'email' => 'pepe@pepe.com',
                'email_verified_at' => now(),
                'rol_id' => 3, // Adjust the role ID as needed
                'blocked' => false,
                'strikes' => 0,
                'created_at' => now(),
            ],

        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }



    }
}
