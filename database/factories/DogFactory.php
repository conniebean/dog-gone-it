<?php

namespace Database\Factories;

use App\Models\Dog;
use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dog>
 */
class DogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $owners = Owner::all();
        return [
            'id' => $this->faker->unique()->randomNumber(),
            'name' => $this->faker->name(),
            'breed' => $this->faker->randomElement(Dog::BREEDS),
            'sex' => $this->faker->randomElement(Dog::GENDER),
            'date_of_birth' => $this->faker->date(),
            'owner_id' => $owners->random()->id,
            'fixed' => $this->faker->boolean()
        ];
    }
}
