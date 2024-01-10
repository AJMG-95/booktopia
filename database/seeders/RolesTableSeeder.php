<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar registros en la tabla roles
        DB::table('roles')->insert([
            ['rol_name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['rol_name' => 'subadmin', 'created_at' => now(), 'updated_at' => now()],
            ['rol_name' => 'user', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
