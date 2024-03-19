<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OwnerResource extends JsonResource
{
    public bool $preserveKeys = true;

    public static $wrap = 'owner';

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
        ];
    }
}
