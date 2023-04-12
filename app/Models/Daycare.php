<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Daycare extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'daycare';

    public const MAX_OCCUPANCY = 20;

    public const VISIT_TYPE = [
        'half-day' => 'half-day',
        'full-day' => 'full-day'
    ];

    public function dogs(): HasMany
    {
        return $this->hasMany(Dog::class, 'dog_id', 'id');
    }

    public function scopeMaxReached($query, $date): bool
    {
        return $query->where('daycare-date', $date)->count() === self::MAX_OCCUPANCY;
    }
}
