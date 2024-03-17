<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class StoreOwnerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'=>[
                'required',
                'string'
            ],
            'address'=>[
                'required',
                'string'
            ],
            'phone_number'=>[
                'required',
                'string'
            ],
            'email'=>[
                'required',
                'string'
            ]
        ];
    }
}
