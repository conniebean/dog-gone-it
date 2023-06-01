<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vaccine extends Model
{
    use HasFactory;

    public const REQUIRED_VACCINES = [
        'RABIES' => 'RABIES',
        'DA2PP' => 'DA2PP',
        'BORDETELLA' => 'BORDETELLA'
    ];

    protected $guarded = [];

    public function dogs(): BelongsToMany
    {
        return $this->belongsToMany(Dog::class)->withPivot([]);
    }
}
