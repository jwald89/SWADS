<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Municipality extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'municipality'];

    public function user()
    {
        return $this->hasMany(User::class, 'mun_id', 'id');
    }

    public function barangay()
    {
        return $this->hasMany(Barangay::class, 'municipality_id', 'id');
    }

    public function sectoral()
    {
        return $this->hasMany(Sectoral::class, 'id', 'municipality');
    }
}
