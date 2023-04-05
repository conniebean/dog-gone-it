<?php

namespace Database\Factories;

use App\Models\Daycare;
use App\Models\Dog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Daycare>
 */
class DaycareFactory extends Factory
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
            'visit-type' => $this->faker->randomElement(Daycare::VISIT_TYPE),
            'paid' => $this->faker->boolean,
            'daycare-date' => $this->faker->dateTimeBetween('now', '+1 month')
        ];
    }
}
