<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionCategory extends Model
{
    use SoftDeletes;
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'category_id');
    }
}
