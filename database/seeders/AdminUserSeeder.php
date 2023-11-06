<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Define los datos para el administrador
        $adminData = [
            'nickname' => 'admin',
            'name' => 'Admin',
            'surnames' => 'User',
            'password' => Hash::make('tu-contraseña-segura'),
            'birth_date' => '1995-09-27', // Ajusta la fecha de nacimiento
            'country_id' => 1, // Ajusta el ID del país según la carga inicial de países
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'rol_id' => 1, // Ajusta el ID del rol según la carga inicial de roles
            'blocked' => false,
            'strikes' => 0,
            'created_at' => now(),
        ];

        // Inserta el administrador en la tabla "users"
        DB::table('users')->insert($adminData);
    }
}
