<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public bool $preserveKeys = true;

    public static $wrap = 'appointment';

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'dog_id' => $this->dog_id,
            'facility_id' => $this->facility_id,
            'appointmentable_id' => $this->appointmentable_id,
            'appointmentable_type' => $this->appointmentable_type,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'appointment_date' => $this->appointment_date,
            'paid' => $this->paid,
        ];
    }
}
