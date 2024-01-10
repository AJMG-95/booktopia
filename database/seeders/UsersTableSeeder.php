<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar registros en la tabla users
        DB::table('users')->insert([
            [
                'nickname' => 'admin_user',
                'name' => 'Admin',
                'surnames' => 'User',
                'password' => Hash::make('admin'),
                'email' => 'admin@admin.com',
                'birth_date' => '1990-01-01',
                'country_id' => 1, // Reemplaza con el ID correcto de un país en tu aplicación
                'profile_img' => 'admin_profile.jpg',
                'rol_id' => 1, // ID del rol 'admin'
                'strikes' => 0,
                'blocked' => false,
                'deleted' => false,
                'biography' => 'Admin user biography.',
                'isAuthor' => false,
                'user_as_author_id' => null,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nickname' => 'subadmin_user',
                'name' => 'Subadmin',
                'surnames' => 'User',
                'password' => Hash::make('subadmin'),
                'email' => 'subadmin@subadmin.com',
                'birth_date' => '1990-02-01',
                'country_id' => 2, // Reemplaza con el ID correcto de otro país en tu aplicación
                'profile_img' => 'subadmin_profile.jpg',
                'rol_id' => 2, // ID del rol 'subadmin'
                'strikes' => 0,
                'blocked' => false,
                'deleted' => false,
                'biography' => 'Subadmin user biography.',
                'isAuthor' => false,
                'user_as_author_id' => null,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nickname' => 'regular_user',
                'name' => 'Regular',
                'surnames' => 'User',
                'password' => Hash::make('user'),
                'email' => 'user@user.com',
                'birth_date' => '1990-03-01',
                'country_id' => 3, // Reemplaza con el ID correcto de otro país en tu aplicación
                'profile_img' => 'user_profile.jpg',
                'rol_id' => 3, // ID del rol 'user'
                'strikes' => 0,
                'blocked' => false,
                'deleted' => false,
                'biography' => 'Regular user biography.',
                'isAuthor' => false,
                'user_as_author_id' => null,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
