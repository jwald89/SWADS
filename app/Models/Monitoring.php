<?php

namespace App\Models;

use App\Models\User;
use App\Models\Sector;
use App\Models\AssistanceType;
use App\Models\PersonalInformation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Monitoring extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'claimant', 'date_encoded', 'beneficiary', 'age', 'sex', 'contact_no', 'sector', 'municipality', 'barangay', 'client_type', 'assistance_type', 'amount', 'charges', 'date_intake', 'staff_admin', 'liaison', 'status_date', 'remarks', 'status', 'created_by', 'deleted_at', 'modified_by', 'modified_date'];


    public function user()
    {
        return $this->belongsTo(User::class, 'liaison', 'id');
    }

    public function intake()
    {
        return $this->belongsTo(PersonalInformation::class, 'claimant', 'id');
    }

    public function sectorName()
    {
        return $this->belongsTo(Sector::class, 'sector', 'id');
    }

    public function assistance()
    {
        return $this->belongsTo(AssistanceType::class, 'assistance_type', 'id');
    }

    public function brgy()
    {
        return $this->belongsTo(Barangay::class, 'barangay', 'id');
    }

    public function municipal()
    {
        return $this->belongsTo(Municipality::class, 'municipality', 'id');
    }

    public function chargingOffice()
    {
        return $this->belongsTo(Office::class, 'charges', 'id');
    }
}
