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
            ['morph' => (new Daycare())->getMorphClass(), 'class' => Daycare::class],
            ['morph' => (new Boarding())->getMorphClass(), 'class' => Boarding::class],
            ['morph' => (new Grooming())->getMorphClass(), 'class' => Grooming::class],
        ];
        $randomAppointment = $this->faker->randomElement($appointmentable_types);
        return [
            'dog_id' => Dog::factory(),
            'facility_id' => 1,
            'visit_type' => $this->faker->randomElement($randomAppointment['class']::VISIT_TYPE),
            'appointmentable_id' => $randomAppointment['class']::factory(),
            'appointmentable_type' => $randomAppointment['morph'],
            'appointment_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'paid' => $this->faker->boolean
        ];
    }
}
