<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
    use HasFactory;

    public function sectoral()
    {
        return $this->hasMany(Sectoral::class, 'id', 'physical_disability');
    }
}
