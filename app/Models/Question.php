<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'category_id',
        'scope_id',
        'user_id',
        'name',
        'description',
        'level',
        'hit',
        'correct_rate',
        'reference',
        'status'
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'status' => 'boolean'
    ];

    public function papers()
    {
        return $this->belongsToMany(Paper::class, 'paper_questions', 'question_id', 'paper_id')
                    ->withTimestamps()
                    ->withPivot(
                        'options',
                        'answer',
                        'score',
                        'correct',
                        'started_at',
                        'finished_at',
                        'seconds_used'
                    );
    }

    public function paperQuestions()
    {
        return $this->hasMany(PaperQuestion::class);
    }

    public function category()
    {
        return $this->belongsTo(QuestionCategory::class);
    }

    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }
    
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function scopeEnabled($query)
    {
        return $query->where('status', true);
    }
}
