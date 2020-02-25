<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{


    protected $fillable = [
        'title',
        'parent_id',
        'order',
        'logo',
        'status',
        'link'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
