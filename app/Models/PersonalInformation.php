<?php

namespace App\Models;

use App\Models\AssistanceType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalInformation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'case_no', 'classification', 'ips', 'category', 'sector_type', 'date_intake', 'last_name', 'first_name', 'middle_name', 'nick_name', 'extn_name', 'age', 'barangay', 'purok', 'street', 'municipality', 'case', 'sex', 'civil_stats', 'birthdate', 'job', 'educ_attainment', 'contact_no', 'income', 'ofis_charge', 'created_by', 'modified_by', 'modified_date', 'deleted_by', 'deleted_at'];

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

    public function brgy()
    {
        return $this->belongsTo(Barangay::class, 'barangay', 'id');
    }

    public function municipal()
    {
        return $this->belongsTo(Municipality::class, 'municipality', 'id');
    }

    public function sectorName()
    {
        return $this->belongsTo(Sector::class, 'sector_type', 'id');
    }

    public function chargingOffice()
    {
        return $this->belongsTo(Office::class, 'ofis_charge', 'id');
    }

    public function indigent()
    {
        return $this->belongsTo(IndigentPeople::class, 'ips', 'id');
    }

    public function classific()
    {
        return $this->belongsTo(Classification::class, 'classification', 'id');
    }
}
