<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['rol_name' => 'admin', 'id' => 1],
            ['rol_name' => 'subadmin', 'id' => 2],
            ['rol_name' => 'user', 'id' => 3],
        ]);
    }
}

