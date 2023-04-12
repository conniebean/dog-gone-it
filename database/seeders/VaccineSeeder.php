<?php

namespace Database\Seeders;

use App\Models\Vaccine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vaccine::factory()->required(Vaccine::REQUIRED_VACCINES['RABIES'])->create();
        Vaccine::factory()->required(Vaccine::REQUIRED_VACCINES['DA2PP'])->create();
        Vaccine::factory()->required(Vaccine::REQUIRED_VACCINES['BORDETELLA'])->create();
    }
}
