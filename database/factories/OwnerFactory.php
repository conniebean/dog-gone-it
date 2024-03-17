<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Owner>
 */
class OwnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => "{$this->faker->firstName()} {$this->faker->lastName()}",
            'address' => $this->faker->address(),
            'phone_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->word() . rand(10, 999) . '@example.com'
        ];
    }
}
