<?php

namespace App\Http\Requests\Dog;

use App\Models\Dog;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDogRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'string|max:30',
            'breed' => 'string|max:50',
            'sex' => '',
            'owner_id' => 'exists:owners,id',
            'date_of_birth' => 'date',
            'fixed' => 'boolean'
        ];
    }
}
