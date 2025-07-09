<?php

namespace App\Models;

use App\Http\Requests\ChildDevRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Municipality extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'municipality',
        'modified_by',
        'modified_date'
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'municipality', 'id');
    }

    public function brgy()
    {
        return $this->hasMany(Barangay::class, 'municipality_id', 'id');
    }

    public function sectoral()
    {
        return $this->hasMany(Sectoral::class, 'id', 'municipality');
    }

    public function intake()
    {
        return $this->hasMany(PersonalInformation::class, 'id', 'municipality');
    }

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class, 'id', 'municipality');
    }

    public function childDevelop()
    {
        return $this->hasMany(ChildDevelopment::class, 'id', 'municipality');
    }

    public function medicine()
    {
        return $this->hasMany(Medicine::class, 'id', 'municipality');
    }
}
