<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    use HasFactory;

    protected $fillable = ['classification', 'category', 'date_intake', 'last_name', 'first_name', 'middle_name', 'nick_name', 'extn_name', 'age', 'barangay', 'purok', 'street', 'municipality', 'sex', 'civil_stats', 'birthdate', 'job', 'contact_no', 'income'];

    public function familyCompose()
    {
    }
}
