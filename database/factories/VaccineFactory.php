<?php

namespace Database\Factories;

use App\Models\Dog;
use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vaccine>
 */
class VaccineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dogs = Dog::all();

        $expires = $this->faker->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d');
        $upToDate = $expires >= now()->format('Y-m-d');
        return [
            'dog_id' => $dogs->random()->id,
            'name' => $this->faker->randomElement(Vaccine::VACCINES),
            'expires' => $expires,
            'up_to_date' => $upToDate,
            'required' => true
        ];
    }
}
