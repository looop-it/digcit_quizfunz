<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name',
        'image',
        'url',
        'enabled',
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'enabled' => 'boolean'
    ];
    
    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }
}
