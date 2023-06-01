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

    // TODO: add a 'notes' table that relates to the dogs
    protected $guarded = [];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function vaccines(): BelongsToMany
    {
        return $this->belongsToMany(Vaccine::class)->withPivot(['expiry_date']);
    }

    public function setExpiryToNull()
    {
        if ($this->vaccines()->wherePivot('expiry_date', '<=', now())->get()){
            foreach ($this->vaccines() as $vaccine) {
                $this->vaccines()->updateExistingPivot($vaccine->id, [
                    'expiry_date' => null
                ]);
            }
        }
    }

    public function hasAllRequiredVaccines(): bool
    {
        $requiredVaccines = Vaccine::where('required', true)->pluck('id')->toArray();
        $receivedVaccines = $this->vaccines()->whereIn('id', $requiredVaccines)->pluck('id')->toArray();
        return empty(array_diff($requiredVaccines, $receivedVaccines));
    }

    public function isUpToDate(): bool
    {
        $expiredVaccines = $this->vaccines()
            ->wherePivot('expiry_date', '<=', now())
            ->wherePivotNotNull('expiry_date')
            ->get();

        if ($expiredVaccines->isNotEmpty()) {
            foreach ($expiredVaccines as $vaccine) {
                $this->vaccines()->updateExistingPivot($vaccine->id, [
                    'expiry_date' => null
                ]);
            }
        }

        return !$this->vaccines()->whereNull('expiry_date')->exists() && $this->hasAllRequiredVaccines();
    }
}
