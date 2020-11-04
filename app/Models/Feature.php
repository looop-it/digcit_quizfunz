<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Feature extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'remark',
        'order1',
        'status',
        'parent_id',
    ];

    public function posts()
    {
       return $this->belongsToMany(Post::class, 'feature_posts', 'feature_id', 'post_id');
    }

    public function linkedPosts()
    {
        return $this->hasMany(FeaturePost::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
