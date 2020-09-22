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
        'verified_at'
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'verified' => 'boolean'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
