<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponseTime extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'user_id',
        'time',
        'user_agent'
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'user_agent' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
