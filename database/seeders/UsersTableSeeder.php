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
        DB::table('users')->insert([
            [
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
            // You can add more user data here if needed
        ]);
    }
}
