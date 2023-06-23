<?php

namespace App\Http\Requests\Dog;

use App\Models\Dog;
use Illuminate\Foundation\Http\FormRequest;

class StoreDogRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required|string|max:30',
            'breed' => 'required|string|max:50',
            'sex' => 'required',
            'owner_id' => 'required|exists:owners,id',
            'date_of_birth' => 'required|date',
            'fixed' => 'required|boolean'
        ];
    }
}
