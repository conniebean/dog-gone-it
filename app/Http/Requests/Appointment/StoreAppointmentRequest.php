<?php

namespace App\Http\Requests\Appointment;

use App\Rules\DaycareHasCapacity;
use App\Rules\DogAlreadyInDaycare;
use App\Rules\DogHasUpToDateVaccines;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'dog_id' => [
                'required',
                'integer',
                new DogAlreadyInDaycare($this->validationData()['appointment_date']),
                new DogHasUpToDateVaccines(),
            ],
            'facility_id' => ['required', 'integer',],
            'appointmentable_id' => 'required|integer',
            'appointmentable_type' => 'required|string',
            'visit_type' => 'string',
            'check_in' => 'date',
            'check_out' => 'date',
            'appointment_date' => [
                'required',
                'date',
                'after_or_equal:today',
                new DaycareHasCapacity(),
            ],
            'paid' => 'required|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'appointment_date.after_or_equal' => 'Daycare-date must be today or a date in the future.'
        ];
    }
}
