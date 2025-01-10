<?php

namespace App\Models;

use App\Models\Sector;
use App\Models\Barangay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sectoral extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id', 'first_name', 'middle_name', 'last_name', 'date_encoded', 'sector', 'age', 'sex', 'nationality', 'religion', 'ethnicity', 'purok', 'barangay', 'municipality', 'birthdate', 'place_birth', 'physical_disability', 'civil_status', 'contact_no', 'fb_accnt', 'school_last_attend', 'month_year', 'skills', 'interest_hobby', 'work_exp', 'org_membership', 'fam_members', 'ISY_OSY', 'position', 'status', 'created_by', 'deleted_at'];

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector', 'id');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality', 'id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'municipality', 'municipality');
    }
}
