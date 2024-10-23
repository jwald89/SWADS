<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sectoral extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id', 'first_name', 'middle_name', 'last_name', 'age', 'sex', 'nationality', 'religion', 'ethnicity', 'purok', 'barangay', 'municipality', 'birthdate', 'place_birth', 'physical_disability', 'civil_status', 'contact_no', 'fb_accct', 'school_last_attend', 'month_year', 'skills', 'interest_hobby', 'work_exp', 'org_membership', 'fam_members', 'ISY_OSY', 'position', 'status'];
}
