<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndigentPeople extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'modified_by', 'modified_date'];

    public function intake()
    {
        return $this->hasMany(PersonalInformation::class, 'id', 'ips');
    }

    public function sectoral()
    {
        return $this->hasMany(Sectoral::class, 'id', 'ethnicity');
    }
}
