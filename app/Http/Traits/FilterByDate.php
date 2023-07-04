<?php

namespace App\Http\Traits;

use Carbon\Carbon;

trait FilterByDate
{
    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', Carbon::today());
    }
}
