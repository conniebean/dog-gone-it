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

    public function scopeDaycareMaxReached($query, $date): bool
    {
        //todo: this is passing but need no hard coded value for daycare_capacity
        return $query
                ->join('appointments', 'appointments.facility_id', '=', 'facilities.id')
                ->where('appointments.appointment_date', $date)->count() === 20; //should be specific facility.daycare_capacity;
    }
}
