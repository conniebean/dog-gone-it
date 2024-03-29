<?php

namespace Database\Factories\Traits;

trait DogNameRandomizer
{
    public function dogName()
    {
        return $this->faker->randomElement([
            'Midna',
            'Aston',
            'Donut',
            'Stretch',
            'Marshall',
            'Wendell',
            'Chompers',
            'Ellie',
            'Louie',
            'Rex',
            'Foster',
            'Bruno',
            'Max',
            'Mia',
            'Chase',
            'Raven',
            'Apollo',
            'Simba',
            'Bo',
            'Olive',
            'Sandy',
            'Luna',
            'Allie',
            'Hannah',
            'Dakota',
            'Alex',
            'Lucky',
            'Benny',
            'Nikki',
            'Jake',
            'Holly',
            'Diesel',
            'Panda',
            'Cookie',
            'Harley',
            'Maverick',
            'Yoda',
            'Ollie',
            'Koda',
            'Moose',
            'Bentley',
            'Ruby',
            'Buster',
            'Chloe',
            'Winston',
            'Hunter',
            'Chico',
            'Shadow',
            'Astro',
            'Sherman',
            'Milo',
            'Abby',
            'Sadie',
            'Scout',
            'Katie',
            'Chewy',
            'Athena',
        ]);
    }
}
