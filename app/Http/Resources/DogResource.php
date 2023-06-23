<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'breed' => $this->breed,
            'sex' => $this->sex,
            'owner_id' => $this->owner_id,
            'date_of_birth' => $this->date_of_birth,
            'fixed' => $this->fixed,
        ];
    }
}
