<?php

namespace Database\Factories\Traits;

trait DogNameRandomizer
{
    public function dogName()
    {
        return $this->faker->randomElement(['Midna',  'Aston', 'Donut', 'Stretch', 'Marshall', 'Wendell', 'Wendel', 'Chompers']);
    }
}
