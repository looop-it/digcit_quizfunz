<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'published_at',
        'published',
        'hits',
        'last_modify_user',
        'featured'
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'published' => 'boolean',
        'featured' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where([['published', '=', 1]]);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class)->withPivot('caption');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    //for laravel-admin form one->many
    public function feature()
    {
        return $this->hasMany(FeaturePost::class);
    }
}
