<?php

namespace App\Http\Requests\Appointment;

use App\Rules\DaycareHasCapacity;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    public function rules()
    {
        $validated = [
            'dog_id' => 'required|integer',
            'facility_id' => ['required', 'integer',],
            'appointmentable_id' => 'required|integer',
            'appointmentable_type' => 'required|string',
            'visit_type' => 'string',
            'check_in' => 'date',
            'check_out' =>  'date',
            'appointment_date' => ['required', 'date', 'after_or_equal:today', new DaycareHasCapacity()],
            'paid' => 'required|boolean'
        ];

        return $validated;
    }
}
