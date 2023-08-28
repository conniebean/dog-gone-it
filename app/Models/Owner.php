<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function dogs(): HasMany
    {
        return $this->hasMany(Dog::class, 'owner_id', 'id');
    }

    public function last_name()
    {
        $lastName = explode(" ", $this->name);

        return $lastName[1];
    }

}
