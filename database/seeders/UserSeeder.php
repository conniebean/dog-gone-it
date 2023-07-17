<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)->create();
        User::factory()->create([
            'name' => 'Connie Kennedy',
            'email' => 'c.kennedy@doggoneit.com',
            'password' => 'password',
            'role_id' => 2
        ]);
    }
}
