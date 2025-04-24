<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamRelationship extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'modified_by', 'modified_date'];

    public function famCompose()
    {
        return $this->hasMany(FamilyComposition::class, 'id', 'relationship');
    }

    public function medicine()
    {
        return $this->hasMany(Medicine::class, 'id', 'relationship');
    }
}
