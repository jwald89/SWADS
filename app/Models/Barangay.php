<?php

namespace App\Models;

use App\Models\Sectoral;
use App\Models\Municipality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'municipality_id',
        'barangay',
        'modified_by',
        'modified_date'
    ];

    public function municipal()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id', 'id');
    }

    public function sectoral()
    {
        return $this->hasMany(Sectoral::class, 'barangay', 'id');
    }

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class, 'id', 'barangay');
    }

    public function intake()
    {
        return $this->belongsTo(Monitoring::class, 'barangay', 'id');
    }

    public function childDevelop()
    {
        return $this->hasMany(ChildDevelopment::class, 'id', 'barangay');
    }

    public function medicine()
    {
        return $this->hasMany(Medicine::class, 'id', 'brgy');
    }
}
