<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = [
        'name',
        'cover_image',
        'desc',
        'link',
        'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
