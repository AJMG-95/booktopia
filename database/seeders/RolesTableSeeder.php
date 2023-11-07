<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the seeder.
     */
    public function run()
    {
        $roles = [
            ['rol_name' => 'admin', 'id' => 1],
            ['rol_name' => 'subadmin', 'id' => 2],
            ['rol_name' => 'user', 'id' => 3],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }
    }
}
