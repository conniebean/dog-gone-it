<?php

namespace Database\Factories\Traits;

trait DogNameRandomizer
{
    public function dogName()
    {
        return $this->faker->randomElement(
            [
                'Midna',
                'Aston',
                'Donut',
                'Stretch',
                'Marshall',
                'Wendell',
                'Walter',
                'Chompers',
                'Douglas',
                'Finnegan',
                'Snickers',
                'Chloe',
                'Murphy',
                'Molly',
                'Charlie',
                'Penny',
                'Reba',
                'Mopsy',
                'Dusty'
            ]);
    }
}
