<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id', 'applicant_id', 'content'];

    public function personalInfo()
    {
        return $this->belongsTo(PersonalInformation::class, 'id', 'applicant_id');
    }
}
