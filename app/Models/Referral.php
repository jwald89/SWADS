<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'applicant_id', 'content', 'created_by'];

    public function personalInfo()
    {
        return $this->belongsTo(PersonalInformation::class, 'id', 'applicant_id');
    }
}
