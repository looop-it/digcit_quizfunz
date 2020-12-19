<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Events\CompetitionStarted;
use App\Events\CompetitionFinished;

class Paper extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'participant_id',
        'season_id',
        'number',
        'difficulty',
        'status',
        'score',
        'started_at',
        'finished_at',
        'seconds_used',
        'questions_answered'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'paper_questions', 'paper_id', 'question_id')
            ->withTimestamps()
            ->withPivot(
                'id',
                'options',
                'answer',
                'correct',
                'score',
                'started_at',
                'finished_at',
                'seconds_used'
            )->oldest('paper_questions.id'); // Order by paper_questions id asc
    }

    public function paperQuestions()
    {
        return $this->hasMany(PaperQuestion::class)->oldest('paper_questions.id'); // Order by paper_questions id asc
    }

    public function getUserAttribute()
    {
        return $this->participant->user;
    }

    /**
     * Scope a query to timeout papers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTimeout($query, $paperTimeLimit)
    {
        $timeLimit = $paperTimeLimit + config('competition.global.paper_time_limit_buffer');

        return $query->where('status', 'processing')
                     ->whereNotNull('started_at')
                     ->whereNull('finished_at')
                     ->where('started_at', '<=', Carbon::now()->subSeconds($timeLimit));
    }

    /**
     * Scope a query to specific season ID.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param integer $seasonId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInSeason($query, $seasonId)
    {
        return $query->where('season_id', $seasonId);
    }

    /**
     * Scope a query to processing paper.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    /**
     * Scope a query to reviewing paper.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReviewing($query)
    {
        return $query->where('status', 'reviewing');
    }

    /**
     * Scope a query to finished paper.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFinished($query)
    {
        return $query->where('status', 'finished');
    }
    
    /**
     * Check if the status of paper is proccessing.
     *
     * @return boolean
     */
    public function isProcessing()
    {
        return $this->status == 'processing';
    }

    public function isReviewing()
    {
        return $this->status == 'reviewing';
    }

    public function isFinished()
    {
        return $this->status == 'finished';
    }
    
    public static function countPapers()
    {
        return count(self::select('id')->where('status', '=', 'processing')->get());
    }
}
