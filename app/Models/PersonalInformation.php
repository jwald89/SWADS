<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'classification', 'category', 'date_intake', 'last_name', 'first_name', 'middle_name', 'nick_name', 'extn_name', 'age', 'barangay', 'purok', 'street', 'municipality', 'sex', 'civil_stats', 'birthdate', 'job', 'contact_no', 'income', 'created_by'];


    public function famCompose()
    {
        return $this->hasMany(FamilyComposition::class, 'applicant_id', 'id');
    }

    public function referral()
    {
        return $this->hasMany(Referral::class, 'applicant_id', 'id');
    }

    public function remark()
    {
        return $this->hasMany(Remark::class, 'applicant_id', 'id');
    }

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class, 'claimant', 'id');
    }
}
