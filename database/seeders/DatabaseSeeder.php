<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        (new RoleSeeder())->run();
        (new UserSeeder())->run();
        (new FacilitySeeder())->run();
        (new OwnerSeeder())->run();
        (new VaccineSeeder())->run();
        (new DogSeeder())->run();
        (new AppointmentSeeder())->run();
    }
}
