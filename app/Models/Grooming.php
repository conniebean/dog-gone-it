<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Grooming extends Model
{
    use HasFactory;

    protected $table ='grooming';

    protected $guarded = [];

    public const VISIT_TYPE = [
        'full-groom',
        'bath-and-brush',
        'nail-trim'
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
