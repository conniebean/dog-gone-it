<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dog extends Model
{
    use HasFactory;

    const GENDER = ['MALE', 'FEMALE'];

    const BREEDS = [
        'German Shepherd',
        'Husky',
        'Dachshund',
        'Beagle',
        'Border Collie',
        'Dutch Shepherd',
        'Pomeranian',
        'Shiba Inu',
        'Malinois',
        'Golden Retriever'
    ];

    protected $guarded = [];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function vaccines(): HasMany
    {
        return $this->hasMany(Vaccine::class);
    }

    public function hasAllRequiredVaccines(): bool
    {
        return $this->vaccines()->where('required', true)-> count() === 3;
    }

    public function isUpToDate(): bool
    {
        return $this->vaccines()->where('up_to_date', false)->count() === 0 && $this->hasAllRequiredVaccines();
    }
}
