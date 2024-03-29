<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(['role_name' => Role::ROLE_NAMES['EMPLOYEE']]);
        DB::table('roles')->insert(['role_name' => Role::ROLE_NAMES['ADMIN']]);
    }
}
