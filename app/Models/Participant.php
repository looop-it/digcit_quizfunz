<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Participant extends Model
{
    use SoftDeletes;
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'user_id',
        'school_id',
        'school_name',
        'name',
        'grade',
        'class',
        'organization_id',
        'organization_name',
        'department'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function papers()
    {
        return $this->hasMany(Paper::class);
    }

    public function bestScores()
    {
        return $this->hasMany(BasicScore::class);
    }

    public function isInformationCompleted()
    {
        if (($this->school_id || $this->school_name) && $this->name && $this->grade && $this->class) {
            return true;
        }

        return false;
    }
}
