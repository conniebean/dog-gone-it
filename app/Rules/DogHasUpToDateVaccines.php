<?php

namespace App\Rules;

use App\Models\Dog;
use Illuminate\Contracts\Validation\Rule;

class DogHasUpToDateVaccines implements Rule
{
    private $appointmentable_type;

    public function __construct($appointmentable_type)
    {
        $this->appointmentable_type = $appointmentable_type;
    }

    public function passes($attribute, $value): bool
    {
        return Dog::query()
            ->where('id', $value)
            ->firstOrFail()
            ->isUpToDate();
    }

    public function message(): string
    {
        return "The vaccines for this pet are out of date, or they do not have all the required vaccines! They cannot come to $this->appointmentable_type.";
    }
}
