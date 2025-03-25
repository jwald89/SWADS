<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'tfund',
        'obr_no',
        'obr_date',
        'claimant',
        'remarks',
        'status',
        'liaison',
        'pr_no',
        'pr_amt',
        'po_date',
        'po_no',
        'po_description',
        'po_amt',
        'dv_date',
        'dv_no',
        'dv_amt',
        'check_date',
        'check_no',
        'check_amt',
        'created_by',
        'modified_by',
        'modified_date',
        'deleted_by',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function transExtn()
    {
        return $this->hasMany(TransactionExtn::class, 'id', 'trans_id');
    }
}
