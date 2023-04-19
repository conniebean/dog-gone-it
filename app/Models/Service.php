<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Service extends Model
{
    use HasFactory;

    public const SERVICES = [
        'daycare',
        'grooming',
        'boarding'
    ];

    protected $guarded = [];

    public function dog(): HasOne
    {
        return $this->hasOne(Dog::Class);
    }

    public function appointments(): BelongsToMany
    {
        return $this->belongsToMany(Appointment::class);
    }

    public function servicable(): MorphTo
    {
        return $this->morphTo();
    }

    public function daycare(): MorphTo
    {
        return $this->morphTo(self::SERVICES['daycare'], 'serviceable_type', 'serviceable_id');
    }

    public function grooming(): MorphTo
    {
        return $this->morphTo(self::SERVICES['grooming'], 'serviceable_type', 'serviceable_id');
    }

    public function boarding(): MorphTo
    {
        return $this->morphTo(self::SERVICES['boarding'], 'serviceable_type', 'serviceable_id');
    }
}