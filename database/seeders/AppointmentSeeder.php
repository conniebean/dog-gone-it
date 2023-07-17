<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Appointment::factory(15)->sequence(
            ['appointment_date' => Carbon::today()],
            ['appointment_date' => Carbon::tomorrow()],
            ['appointment_date' => Carbon::now()->addWeek()],
            ['appointment_date' => Carbon::yesterday()],
        )->create();
    }
}
