<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Sectoral;
use App\Models\Monitoring;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Laravel\Pennant\Concerns\HasFeatures;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasFeatures;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $fillable = [
        'last_name',
        'first_name',
        'middle_init',
        'username',
        'title',
        'designation',
        'email',
        'password',
        'municipality',
        'role_type',
        'modified_by',
        'modified_date'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.3
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality', 'id');
    }

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class, 'id', 'liaison');
    }

    public function sectoral()
    {
        return $this->hasMany(Sectoral::class, 'municipality', 'municipality');
    }

    public function personalInfo()
    {
        return $this->hasMany(PersonalInformation::class, 'id', 'created_at');
    }

    public function medicine()
    {
        return $this->hasMany(Medicine::class, 'id', 'created_by');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'id', 'created_by');
    }
}
