<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function appointmentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function dog(): HasOne
    {
        return $this->hasOne(Dog::Class);
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
