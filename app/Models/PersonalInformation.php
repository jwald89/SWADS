<?php

namespace App\Models;

use App\Models\AssistanceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalInformation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'classification', 'category', 'date_intake', 'last_name', 'first_name', 'middle_name', 'nick_name', 'extn_name', 'age', 'barangay', 'purok', 'street', 'municipality', 'sex', 'civil_stats', 'birthdate', 'job', 'contact_no', 'income', 'created_by', 'deleted_at'];


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

    public function assistance()
    {
        return $this->belongsTo(AssistanceType::class, 'category', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
