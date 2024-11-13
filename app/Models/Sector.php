<?php

namespace App\Models;

use App\Models\Sectoral;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name'];

    public function sectoral()
    {
        return $this->hasMany(Sectoral::class, 'id', 'sector');
    }
}
