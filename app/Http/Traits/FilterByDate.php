<?php

namespace App\Http\Traits;

use Carbon\Carbon;

trait FilterByDate
{
    public function scopeToday($query)
    {
        return $query->where('appointment_date', Carbon::today());
    }

    public function scopeTomorrow($query)
    {
        return $query->where('appointment_date', Carbon::tomorrow());
    }

    public function scopeYesterday($query)
    {
        return $query->where('appointment_date', Carbon::yesterday());
    }
}
