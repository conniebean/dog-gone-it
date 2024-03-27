<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOwnerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'=>[
                'string'
            ],
            'address'=>[
                'string'
            ],
            'phone_number'=>[
                'string'
            ],
            'email'=>[
                'string'
            ]
        ];
    }
}
