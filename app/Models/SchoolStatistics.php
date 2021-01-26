<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolStatistics extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'school_id',
        'season_id',
        'students',
        'participants',
        'scores',
        'seconds'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
