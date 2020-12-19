<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStat extends Model
{
    protected $connection= 'membership';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'user_id',
        'page',
        'ip',
        'stats',
        'created_at'
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'stats' => 'array'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
