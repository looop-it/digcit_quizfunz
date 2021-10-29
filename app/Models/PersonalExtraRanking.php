<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalExtraRanking extends Model
{
    protected $table = 'personal_extra_ranking';

    protected $fillable = [
        'participant_id',
        'added_year',
        'added_week',
        'season_id',
        'sum_scores',
        'sum_seconds',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    /**
     * Add a season scope filter for query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $seasonId [description]
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInSeason($query, $seasonId)
    {
        return $query->where('season_id', $seasonId);
    }

    /**
     * Add a season scope filter for query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInWeek($query, $week_of_year)
    {
        return $query->where('week_of_year', $week_of_year);
    }
}
