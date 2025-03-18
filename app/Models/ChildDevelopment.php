<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildDevelopment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cdc_name',
        'date_encoded',
        'municipality',
        'barangay',
        'purok',
        'sitio',
        'cdw_name',
        'status',
        'lvl_recognition',
        'validity_of_cor',
        'no_entered_children',
        'no_feed_recepients',
        'created_by',
        'modified_by',
        'modified_date'
    ];

    public function brgy()
    {
        return $this->belongsTo(Barangay::class, 'barangay', 'id');
    }

    public function municipal()
    {
        return $this->belongsTo(Municipality::class, 'municipality', 'id');
    }

}
