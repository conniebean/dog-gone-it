<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Daycare extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'daycare';

    //TODO: move this to facility class but add daycare/grooming/boarding max occupancy
//    public const MAX_OCCUPANCY = 20;

    public const VISIT_TYPE = [
        'half-day' => 'half-day',
        'full-day' => 'full-day'
    ];

    public function dogs(): HasMany
    {
        return $this->hasMany(Dog::class, 'dog_id', 'id');
    }

    public function appointments(): morphMany
    {
        return $this->morphMany(Appointment::class, 'appointmentable');
    }
}
