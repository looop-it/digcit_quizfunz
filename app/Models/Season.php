<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Season extends Model
{
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name',
        'status',
        'start_at',
        'end_at',
        'is_intercollegiate',
        'times_limit',
        'time_interval',
        'difficulty',
        'difficulty_offset',
        'general_questions',
        'other_questions',
        'question_score',
        'paper_time_limit',
        'question_time_limit',
        'enable_days',
        'day_start_time',
        'day_end_time'
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'enable_days' => 'array'
    ];

    /**
     * Get the paper records associated with the season.
     *
     * @return void
     */
    public function papers()
    {
        return $this->hasMany(Paper::class);
    }

    public function getParticipantsAttribute()
    {
        return $this->hasMany(BasicScore::class)->count();
    }
    
    /**
     * Scope a query to only available season.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpen($query)
    {
        $now = now();

        return $query->where('status', 'open')
                     ->where('start_at', '<=', $now)
                     ->where('end_at', '>=', $now)
                     ->orderBy('id', 'desc');
    }
}
