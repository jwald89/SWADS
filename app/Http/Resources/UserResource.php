<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'fullname' => ucfirst($this->first_name) .' '. ($this->middle_init !== NULL ? ucfirst(substr($this->middle_init, 0, 1)) .'. ' : '') . ucfirst($this->last_name),
            'role_type' => $this->role_type,
            'title' => $this->title !== NULL ? ucfirst($this->title) : "",
            'designation' => $this->designation !== NULL ? ucfirst($this->designation) : "",
        ];
    }
}
