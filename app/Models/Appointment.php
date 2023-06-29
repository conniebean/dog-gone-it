<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'appointment_date' => 'datetime:Y-m-d'
    ];

    public const APPOINTMENT_TYPES = [
        'daycare',
        'grooming',
        'boarding'
    ];

    public function appointmentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }

    public function dog(): BelongsTo
    {
        return $this->belongsTo(Dog::Class);
    }

    public function daycare(): MorphTo
    {
        return $this->morphTo(Daycare::class, 'appointmentable_type', 'appointmentable_id');
    }
//      TODO: bring these in later when daycare works
//    public function grooming(): MorphTo
//    {
//        return $this->morphTo(self::SERVICES['grooming'], 'appointmentable_type', 'appointmentable_id');
//    }
//
//    public function boarding(): MorphTo
//    {
//        return $this->morphTo(self::SERVICES['boarding'], 'appointmentable_type', 'appointmentable_id');
//    }
}
