<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Models\Post;

class CompetitionInfo extends Model
{
    protected $table = 'competition_info';

    protected $fillable = [
        'title',
        'parent_id',
        'order',
        'content',
        'status'
    ];

    public function children()
    {
        return $this->hasMany(CompetitionInfo::class, 'parent_id');
    }
    
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeOfParent($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }
}
