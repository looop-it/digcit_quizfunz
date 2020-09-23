<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolRegistration extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'school_id',
        'address',
        'name',
        'subject',
        'email',
        'phone',
        'verification_token',
        'verified',
        'verified_at',
        'approved'
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'verified' => 'boolean',
        'approved' => 'boolean'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }
}
