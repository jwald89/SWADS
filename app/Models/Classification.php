<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];

    public function intake()
    {
        return $this->hasMany(PersonalInformation::class, 'id', 'classification');
    }

    public function medicine()
    {
        return $this->hasMany(Medicine::class, 'id', 'classification');
    }
}
