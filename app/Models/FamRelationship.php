<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamRelationship extends Model
{
    use HasFactory;

    public function famCompose()
    {
        return $this->hasMany(FamilyComposition::class, 'id', 'relationship');
    }
}
