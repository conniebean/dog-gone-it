<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

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

    public function scopeHasAllRequiredVaccines($query): bool
    {
        //require vaccines in Vaccine class [rabies, bordetella, da2pp]
        $requiredVaccines = Vaccine::where('required', true)->pluck('name')->toArray();
        $receivedVaccines = $this->vaccines()->whereIn('name', $requiredVaccines)->pluck('name')->toArray();

        return empty(array_diff($requiredVaccines, $receivedVaccines));
    }

    public function isUpToDate(): bool
    {
        return $this->vaccines()->where('up_to_date', false)->count() === 0 && $this->hasAllRequiredVaccines();
    }
}
