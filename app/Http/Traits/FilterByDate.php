<?php

namespace App\Http\Traits;

use Carbon\Carbon;

trait FilterByDate
{
    public function scopeToday($query)
    {
        //todo: scope specifically to appointment type as well
        return $query->whereBetween('appointment_date', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()]);
    }

    public function scopeTomorrow($query)
    {
        return $query->where('appointment_date', Carbon::tomorrow());
    }

    public function scopeYesterday($query)
    {
        return $query->where('appointment_date', Carbon::yesterday());
    }

    public function scopeAppointmentType($query, $type)
    {

        return $query->where('appointmentable_type', (new $type)->getMorphClass());
    }
}
