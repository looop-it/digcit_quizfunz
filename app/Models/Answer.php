<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'question_id',
        'content',
        'correct',
        'hit'
    ];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
        'correct' => 'boolean'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
