<?php

namespace App\Models;

use App\Models\Sectoral;
use App\Models\Monitoring;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sector extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'name', 'deleted_at', 'modified_by', 'modified_date'];

    public function sectoral()
    {
        return $this->hasMany(Sectoral::class, 'id', 'sector');
    }

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class, 'id', 'sector');
    }
}
