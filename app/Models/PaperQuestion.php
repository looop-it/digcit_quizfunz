<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaperQuestion extends Model
{
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'paper_id',
        'question_id',
        'options',
        'answer',
        'correct',
        'score',
        'started_at',
        'finished_at',
        'seconds_used',
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'options' => 'array',
        'answer' => 'array',
        'correct' => 'boolean',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function paper()
    {
        return $this->belongsTo(Paper::class);
    }

    public function scopeOfPaper($query, $id)
    {
        return $query->where('paper_id', $id);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
