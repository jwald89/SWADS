<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyCompositionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $firstname = $this->firstname ?? 'N/A';
        $middlename = $this->middlename ? ucfirst(substr($this->middlename, 0, 1)) . '. ' : '';
        $lastname = $this->lastname ?? '';

        return [
            'id' => $this->id,
            'fullname' => trim(ucwords($firstname) . ' ' . $middlename . ucwords($lastname)),
        ];
    }
}
