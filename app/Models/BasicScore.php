<?php

namespace App\Models;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Model;

class BasicScore extends Model
{
    protected $fillable = [
        'participant_id',
        'season_id',
        'paper_id',
        'score',
        'seconds_used',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    /**
     * Add a season scope filter for query
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  Int $seasonId [description]
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInSeason($query, $seasonId)
    {
        return $query->where('season_id', $seasonId);
    }
}
