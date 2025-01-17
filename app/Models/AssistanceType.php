<?php

namespace App\Models;

use App\Models\Monitoring;
use App\Models\PersonalInformation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssistanceType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'name', 'deleted_at', 'modified_by', 'modified_date'];

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class, 'id', 'assistance_type');
    }

    public function personalInfo()
    {
        return $this->hasMany(PersonalInformation::class, 'id', 'category');
    }
}
