<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyBasicScore extends Model
{
    protected $connection =  'mysql';
    
    protected $fillable = [
        'participant_id',
        'week_of_year',
        'season_id',
        'paper_id',
        'score',
        'seconds_used',
        'started_at',
    ];

    public function getTable()
    {
        $table = parent::getTable();
        
        return config("database.connections.{$this->connection}.database") . ".{$table}";
    }

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
     * @param int                                   $seasonId [description]
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInWeek($query, $week_of_year)
    {
        return $query->where('week_of_year', $week_of_year);
    }
}
