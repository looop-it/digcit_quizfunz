<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
        'logo',
        'desc'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function posts()
    {
        // return $this->belongsToMany(Posts::class,'category_post','category_id','post_id');
        return $this->hasMany(Post::class);
    }

    // public function category_id()
    // {
    //     return $this->id;
    // }
}
