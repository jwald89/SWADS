<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'problem_present',
        'assistance_need',
        'created_by',
        'modified_by',
        'modified_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'created_by');
    }

    public function brgy()
    {
        return $this->belongsTo(Barangay::class, 'id', 'barangay');
    }

    public function municipal()
    {
        return $this->belongsTo(Municipality::class, 'municipality', 'id');
    }

    public function famRelation()
    {
        return $this->belongsTo(FamRelationship::class, 'relationship', 'id');
    }
}
