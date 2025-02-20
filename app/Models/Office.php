<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'description', 'first_name', 'middle_name', 'last_name', 'title', 'modified_by', 'modified_date'];

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class, 'id', 'charges');
    }

    public function intake()
    {
        return $this->hasMany(PersonalInformation::class, 'id', 'ofis_charge');
    }
}


