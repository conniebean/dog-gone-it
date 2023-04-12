<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DogVaccine extends Model
{
    use HasFactory;

    protected $table = 'dog_vaccine';

    public function dog(): BelongsTo
    {
        return $this->belongsTo(Dog::class, 'dog_id', 'id');
    }

    public function vaccine(): BelongsTo
    {
        return $this->belongsTo(Vaccine::class, 'vaccine_id', 'id');
    }
}
