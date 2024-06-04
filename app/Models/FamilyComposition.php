<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyComposition extends Model
{
    use HasFactory;

    protected $fillable = ['lastname', 'firstname', 'middlename', 'age', 'relationship', 'educ_attainment', 'remarks'];
}
