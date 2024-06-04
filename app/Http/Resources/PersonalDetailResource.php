<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'fullname' => $this->last_name .', '. $this->first_name .' '. $this->middle_name,
            'age' => $this->age,
            'gender' => $this->sex,
            'barangay' => $this->barangay,
            'municipality' => $this->municipality,
            'category' => $this->category,
            'date_intake' => $this->date_intake,
        ];
    }
}
