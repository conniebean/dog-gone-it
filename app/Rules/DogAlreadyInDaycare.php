<?php

namespace App\Rules;

use App\Models\Appointment;
use Illuminate\Contracts\Validation\Rule;

class DogAlreadyInDaycare implements Rule
{
    private $appointment_date;

    public function __construct($appointment_date)
    {
        $this->appointment_date = $appointment_date;
    }

    public function passes($attribute, $value): bool
    {
        return Appointment::query()
            ->where('dog_id', $value)
            ->where('appointment_date', $this->appointment_date)->exists();
    }

    public function message(): string
    {
        return "Dog already in daycare for the day.";
    }
}
