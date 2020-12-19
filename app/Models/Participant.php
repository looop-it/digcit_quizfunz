<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Participant extends Model
{
    use SoftDeletes;

    protected $connection = 'membership';
    
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

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        $table = parent::getTable();
        
        return config("database.connections.{$this->connection}.database") . ".{$table}";
    }

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
