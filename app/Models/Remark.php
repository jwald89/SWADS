<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Remark extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'applicant_id',
        'content',
        'cash_assistance',
        'created_by',
        'modified_by',
        'modified_date',
        'deleted_at'
    ];

    public function personalInfo()
    {
        return $this->belongsTo(PersonalInformation::class, 'id', 'applicant_id');
    }

    public function personal()
    {
        return $this->hasMany(PersonalInformation::class, 'applicant_id', 'id');
    }
}
