<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'classification',
        'sector_type',
        'indigent_people',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'brgy',
        'municipality',
        'province',
        'date_started',
        'date_ended',
        'pharmacy',
        'amount',
        'type_assistance',
        'beneficiary',
        'relationship',
        'kinds_of_med',
        'problem_present',
        'assistance_need',
        'created_by',
        'modified_by',
        'modified_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'brgy', 'id');
    }

    public function municipal()
    {
        return $this->belongsTo(Municipality::class, 'municipality', 'id');
    }

    public function famRelation()
    {
        return $this->belongsTo(FamRelationship::class, 'relationship', 'id');
    }

    public function sectorName()
    {
        return $this->belongsTo(Sector::class, 'sector_type', 'id');
    }
}
