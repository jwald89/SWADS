<?php

namespace App\Models;

use App\Models\User;
use App\Models\Sector;
use App\Models\PersonalInformation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Monitoring extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'claimant', 'date_encoded', 'beneficiary', 'age', 'sex', 'contact_no', 'sector', 'municipality', 'barangay', 'client_type', 'assistance_type', 'amount', 'charges', 'date_intake', 'staff_admin', 'liaison', 'status_date', 'remarks', 'status', 'created_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'liaison', 'id');
    }

    public function intake()
    {
        return $this->belongsTo(PersonalInformation::class, 'claimant', 'id');
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector', 'id');
    }

}
