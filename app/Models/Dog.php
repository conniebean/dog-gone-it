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
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }
}
