<?php

namespace Database\Factories;

use App\Models\Daycare;
use App\Models\Dog;
use App\Models\Grooming;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Daycare>
 */
class GroomingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'visit_type' => $this->faker->randomElement(Grooming::VISIT_TYPE),
        ];
    }
}
