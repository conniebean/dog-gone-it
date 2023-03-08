<?php

namespace Database\Seeders;

use App\Models\Dog;
use App\Models\Owner;
use Illuminate\Database\Seeder;

class DogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dog::factory()->times(7)->create();
    }
}
