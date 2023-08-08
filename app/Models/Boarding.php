<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Boarding extends Model
{
    use HasFactory;
    protected $table = 'boarding';

    protected $guarded = [];
    public const VISIT_TYPE = [
        '1-to-3-nights',
        '4-to-7-nights',
        '8-to-14-nights',
        '15-or-more-nights',
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
