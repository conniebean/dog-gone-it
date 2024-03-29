<?php

namespace App\Models;

use App\Http\Traits\FilterByDate;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Appointment extends Model
{
    use HasFactory, FilterByDate;

    protected $guarded = [];

    protected $casts = [
        'appointment_date' => 'datetime:Y-m-d'
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

    public static function daycareVisitTypes(): array
    {
        return Daycare::VISIT_TYPE;
    }
    public function grooming(): MorphTo
    {
        return $this->morphTo(Grooming::class, 'appointmentable_type', 'appointmentable_id');
    }

    public static function groomingVisitTypes(): array
    {
        return Grooming::VISIT_TYPE;
    }

    public function boarding(): MorphTo
    {
        return $this->morphTo(Boarding::class, 'appointmentable_type', 'appointmentable_id');
    }

    public static function boardingVisitTypes(): array
    {
        return Boarding::VISIT_TYPE;
    }
}
