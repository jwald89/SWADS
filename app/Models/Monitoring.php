<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'claimant', 'date_entry', 'beneficiary', 'age', 'sex', 'contact_no', 'sector', 'municipality', 'barangay', 'client_type', 'assistance_type', 'amount', 'charges', 'date_intake', 'staff_admin', 'liaison', 'status_date', 'remarks', 'status', 'created_by'];
}
