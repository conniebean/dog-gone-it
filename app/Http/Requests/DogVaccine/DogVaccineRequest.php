<?php

namespace App\Http\Requests\DogVaccine;

use App\Models\Dog;
use Illuminate\Foundation\Http\FormRequest;

class DogVaccineRequest extends FormRequest
{

    public function rules()
    {
        return [
            'dog_id' => 'required|exists:dogs,id',
            'vaccine_id' => 'required|exists:vaccines,id',
            'expiry_date' => 'required|date'
        ];
    }
}
