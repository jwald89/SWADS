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
}
