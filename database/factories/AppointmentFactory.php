<?php

namespace Database\Factories;

use App\Models\Daycare;
use App\Models\Dog;
use App\Models\Facility;
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
        $dog = Dog::count() ? Dog::all() : Dog::factory(3)->create();
        return [
            'dog_id' => $dog->random()->id,
            'facility_id' => fn () => Facility::factory()->create(),
            //todo: figure out how 'appointmentable_id' works and change it
            'appointmentable_id' => 1,
            //todo: after daycare appt type is working, figure out how to make
            //  random selection of appt type.
            'appointmentable_type' => Daycare::class,
            'appointment_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'paid' => $this->faker->boolean
        ];
    }
}
