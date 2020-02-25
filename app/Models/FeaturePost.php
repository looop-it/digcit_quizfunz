<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FeaturePost extends Model
{
    protected $fillable = [
        'feature_id',
        'post_id',
        'order',
        'caption',
        'parent_id',
        'start_date',
        'end_date',
        'cover_image',
        'mobile_cover_image'
    ];

    public function posts()
    {
        return $this->belongsTo(Post::class);
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    // Get posts that out of date
    public function scopeOutofdate($query)
    {
        return $query->where('end_date', '<', Carbon::now()->subMonth());
    }
}
