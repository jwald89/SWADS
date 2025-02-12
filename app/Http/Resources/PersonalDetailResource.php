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

        return [
            'id' => $this->id,
            'fullname' => ucwords($this->first_name) .' '. ucfirst(substr($this->middle_name, 0, 1)) .'. '. ucwords($this->last_name),
            'age' => $this->age,
            'gender' => $this->sex,
            'contact_no' => $this->contact_no,
            'barangay' => $this->barangay,
            'municipality' => $this->municipality,
            'category' => $this->category,
            'date_intake' => $this->date_intake,
            'created_by' => $this->created_by,
            'assistanceType' => $this->assistance->name ?? null,
            'username' => ucwords($this->user->first_name) .' '. ucfirst(substr($this->user->middle_init, 0, 1)) .'. '. ucwords($this->user->last_name),
            'brgy' => $this->brgy->barangay,
            'municipal' => $this->municipal->municipality,
        ];
    }
}
