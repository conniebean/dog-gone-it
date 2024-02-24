<?php

namespace App\Rules;

use App\Models\Appointment;
use Illuminate\Contracts\Validation\Rule;

class DogAlreadyInAppointment implements Rule
{
    private $appointment_date;
    private $appointmentable_type;

    public function __construct($appointment_date, $appointmentable_type)
    {
        $this->appointment_date = $appointment_date;
        $this->appointmentable_type = $appointmentable_type;
    }

    public function passes($attribute, $value): bool
    {
        return Appointment::query()
            ->where('dog_id', $value)
            ->where('appointmentable_type', $this->appointmentable_type)
            ->where('appointment_date', $this->appointment_date)->doesntExist();
    }

    public function message(): string
    {
        return "Dog already in {$this->appointmentable_type} for the day.";
    }
}
