<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
    public function currentAppointments(): Builder
    {
        return Appointment::query()->where('facility_id', $this->id);
    }

    public function scopeDaycareMaxReached($query, $date, $capacity): bool
    {
        return $query
                ->join('appointments as a', 'a.facility_id', '=', 'facilities.id')
                ->where('a.appointment_date', $date)
                ->count() === $capacity;
    }
}
