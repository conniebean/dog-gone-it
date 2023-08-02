<?php

namespace Database\Factories;

use App\Models\Boarding;
use App\Models\Daycare;
use App\Models\Dog;
use App\Models\Facility;
use App\Models\Grooming;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $appointmentable_types = [
            (new Daycare())->getMorphClass(),
            (new Boarding())->getMorphClass(),
            (new Grooming())->getMorphClass(),
        ];
        $randomAppointment = $this->faker->randomElement($appointmentable_types);
        return [
            'dog_id' => Dog::factory(),
            'facility_id' => Facility::factory(),
            //todo: figure out how 'appointmentable_id' works and change it
            'appointmentable_id' => 1,
            'appointmentable_type' => $randomAppointment,
            'appointment_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'paid' => $this->faker->boolean
        ];
    }
}
