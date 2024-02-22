<?php

namespace Database\Seeders;

use App\Models\Dog;
use App\Models\Owner;
use App\Models\Vaccine;
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
        $dogs = Dog::factory(25)->create();

        $vaccines = Vaccine::where('required', 1)->get();

        $dogs->each(function ($dog) use ($vaccines){
            foreach ($vaccines as $vaccine) {
                $dog->vaccines()->attach($vaccine->id, [
                    'expiry_date' => now()->addYears(2),
                ]);
            }
        });
    }
}
