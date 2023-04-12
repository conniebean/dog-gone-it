<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function vaccines(): BelongsToMany
    {
        return $this->belongsToMany(Vaccine::class)->withPivot([]);
    }

    public function hasAllRequiredVaccines(): bool
    {
        $requiredVaccines = Vaccine::where('required', true)->pluck('id')->toArray();
        $receivedVaccines = $this->vaccines()->whereIn('id', $requiredVaccines)->pluck('id')->toArray();
        return empty(array_diff($requiredVaccines, $receivedVaccines));
    }

    public function isUpToDate(): bool
    {
        return $this->vaccines()->where('up_to_date', false)->count() === 0
            && $this->hasAllRequiredVaccines();
    }
}
