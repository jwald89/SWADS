<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionExtn extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'trans_id',
        'acct_code',
        'particular',
        'amt',
        'is_reimburse',
        'created_by',
        'modified_by',
        'modified_date',
        'deleted_at'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'trans_id', 'id');
    }
}
