<?php

namespace App\Http\Requests\Appointment;

use App\Rules\DaycareHasCapacity;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    public function rules()
    {
        $validated = [
            'facility_id' => 'integer',
            'appointmentable_id' => 'integer',
            'appointmentable_type' => 'string',
            'visit_type' => 'string',
            'check_in' => 'date',
            'check_out' =>  'date',
            'appointment_date' => ['date', 'after_or_equal:today', new DaycareHasCapacity()],
            'paid' => 'boolean'
        ];

        return $validated;
    }
}
