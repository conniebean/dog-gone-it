<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;

    protected $fillable = [
        'dog_id',
        'rabies',
        'da2pp',
        'bordatella',
        'up_to_date',
    ];
}
