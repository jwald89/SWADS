<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyComposition extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'applicant_id',
        'lastname',
        'firstname',
        'middlename',
        'age',
        'relationship',
        'educ_attainment',
        'remarks',
        'created_by',
        'modified_by',
        'modified_date',
        'deleted_at'
    ];

    public function personalInfo()
    {
        return $this->belongsTo(PersonalInformation::class, 'id', 'applicant_id');
    }

    public function famRelation()
    {
        return $this->belongsTo(FamRelationship::class, 'relationship', 'id');
    }
}
