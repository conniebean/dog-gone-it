<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:30',
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
            'role_id' => 'required'
        ];
    }
}
