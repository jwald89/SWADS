<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    use HasFactory;

    protected $fillable = ['classification', 'date_intake', 'lastname', 'firstname', 'middlename', 'nick_name', 'age', 'category', 'sex', 'civil_status', 'birthdate', 'job', 'contact_no'];

    public function familyCompose()
    {
    }
}
