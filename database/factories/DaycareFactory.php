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
        return [
            'visit_type' => $this->faker->randomElement(Daycare::VISIT_TYPE),
        ];
    }
}
