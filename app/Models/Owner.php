<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    use HasFactory;

//    protected $fillable = [
//        'name',
//        'address',
//        'phone_number',
//        'email'
//    ];
    protected $guarded = [];
    public function dogs(): HasMany
    {
        return $this->hasMany(Dog::class);
    }

}
