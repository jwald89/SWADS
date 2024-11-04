<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyComposition extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'applicant_id', 'lastname', 'firstname', 'middlename', 'age', 'relationship', 'educ_attainment', 'remarks', 'created_by'];

    public function personalInfo()
    {
        return $this->belongsTo(PersonalInformation::class, 'id', 'applicant_id');
    }
}
