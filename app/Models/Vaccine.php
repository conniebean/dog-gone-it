<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vaccine extends Model
{
    use HasFactory;

    public const VACCINES = [
        'rabies' => 'RABIES',
        'da2pp' => 'DA2PP',
        'bordetella' => 'BORDETELLA'
    ];

    protected $guarded = [];

    public function dog(): BelongsTo
    {
        return $this->belongsTo(Dog::class);
    }
}
