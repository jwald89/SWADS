<?php

namespace App\Models;

use App\Models\Municipality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'municipality_id', 'barangay'];

    public function municipal()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id', 'id');
    }
}
