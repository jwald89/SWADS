<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Referral extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'applicant_id', 'content', 'created_by', 'deleted_at'];

    public function personalInfo()
    {
        return $this->belongsTo(PersonalInformation::class, 'id', 'applicant_id');
    }
}
